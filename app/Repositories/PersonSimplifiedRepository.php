<?php

namespace App\Repositories;

use App\Http\Requests\StoreUpdatePersonRequest;
use App\Models\Person\Address;
use App\Models\Person\AddressType;
use App\Models\Person\Contact;
use App\Models\Person\ContactType;
use App\Models\Person\Document;
use App\Models\Person\DocumentType;
use App\Models\Person\Person;
use App\Repositories\Contracts\PersonSimplifiedRepositoryInterface;
use App\Enums\AddressType as EnumAddressType;
use App\Enums\ContactType as EnumContactType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class PersonSimplifiedRepository implements PersonSimplifiedRepositoryInterface
{
    private $arrDocumentTypeId = array('F' => 1, 'J' => 2);
    private $arrAddressFields = array('zip_code', 'street', 'number', 'complement', 'state', 'city', 'district', 'reference');
    private $arrContactTypeId = array('email' => 1, 'phone' => 2, 'cell' => 3, 'website' => 4);

    public function __construct(
        protected Person $model
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->Where('name', 'like', "%{$filter}%");
                }
            })
            ->get()
            ->toArray();
    }

    public function getPaginate(int $page = 1, int $totalPerPage = 15, string $filter = null)
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
        return $result;
    }

    public function findOne(string $id): stdClass|null
    {
        $person = $this->model::with(['contacts'])->find($id);
        $person->documents->where('document_type_id', ($person->type == 'F' ? 1 : 2));
        $person->addresses->where('address_type_id', EnumAddressType::HOME);
        if (!$person) {
            return null;
        }
        return (object) $person->toArray();
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

    public function new(StoreUpdatePersonRequest $request, string $model): stdClass
    {
        $person = DB::transaction(function () use ($request, $model) {
            //Create Person
            $person =  Auth::user()->people()->create($request->all());
            //Bind with Categories
            $person->categories()->create(['name' => strtolower($model)]);
            //Bind with Documents
            if ($request->filled('document')) {
                $documentTypeId = $this->arrDocumentTypeId[$request->type];
                $documentType = DocumentType::find($documentTypeId);
                $document = new Document();
                $document->value = $request->document;
                $document->documentType()->associate($documentType);
                $person->documents()->save($document);
            }
            //Bind with Addresses
            if ($request->anyFilled($this->arrAddressFields)) {
                $addressType = AddressType::find(EnumAddressType::HOME);
                $address = new Address($request->only($this->arrAddressFields));
                $address->addressType()->associate($addressType);
                $person->addresses()->save($address);
            }
            //Bind with Contacts
            $arrContactFields = array_keys($this->arrContactTypeId);
            if ($request->anyFilled($arrContactFields)) {
                foreach ($this->arrContactTypeId as $field => $contactTypeId) {
                    if ($request->filled($field)) {
                        $contactType = ContactType::find($contactTypeId);
                        $contact = new Contact();
                        $contact->value = $request->$field;
                        $contact->contactType()->associate($contactType);
                        $person->contacts()->save($contact);
                    }
                }
            }
            return $person;
        });
        return (object)$person->toArray();
    }

    public function update(StoreUpdatePersonRequest $request, string $id): stdClass|null
    {
        $person = DB::transaction(function () use ($request, $id) {
            //Find Person
            if (!$person = $this->model->with(['documents', 'contacts'])->find($id)) {
                return null;
            }

            //Update person data
            $person->fill($request->only('name', 'type'));
            $documentType = $person->type;

            //Checks if the person type has changed
            if ($person->isDirty(['type'])) {
                //If it changed, take the old value
                $documentType = $person->getOriginal('type');
            }

            //Get the specific type of document (F = 1 | J = 2)
            $document = $person->documents->where('document_type_id', $this->arrDocumentTypeId[$documentType])->first();
            $newDocument = true;
            if ($document) {
                $newDocument = false;
                $document->value = $request->document;
                if ($person->isDirty(['type']) or $document->isDirty('value')) {
                    $newDocument = true;
                    //Place the person's document in the trash
                    $document->delete();
                }
            }

            //Create a new document
            if ($newDocument and $request->filled('document')) {
                //Checks if the person's document is in the trash
                $trashedDocument = Document::onlyTrashed()
                    ->where('document_type_id', $this->arrDocumentTypeId[$request->type])
                    ->where('value', $request->document)
                    ->where('person_id', $person->id)
                    ->first();
                if (!$trashedDocument) {
                    //There is no document for the person in the trash, so create a new one
                    $document = new Document();
                    $document->value = $request->document;
                    //Get the document type
                    $documentTypeId = $this->arrDocumentTypeId[$request->type];
                    $documentType = DocumentType::find($documentTypeId);
                    $document->documentType()->associate($documentType);
                    $person->documents()->save($document);
                } else {
                    //Restore the person's document from the trash
                    $trashedDocument->restore();
                }
            }

            //Updates the person's home address
            $address = $person->addresses
                ->where('address_type_id', EnumAddressType::HOME)
                ->where('active', 1)
                ->first();

            if ($request->anyFilled($this->arrAddressFields)) {
                $addressType = AddressType::find(EnumAddressType::HOME);
                $addressVerify = new Address($request->only($this->arrAddressFields));
                $addressVerify->addressType()->associate($addressType);
                $addressVerify->person()->associate($person);
                $calculedDeleteIntegrityCode = $addressVerify->generateDeleteIntegrityCode();

                //Checks if the person's address home is in the trash
                $trashedAddresses = Address::onlyTrashed()
                    ->where('deleted_integrity', $calculedDeleteIntegrityCode)
                    ->first();
                if ($trashedAddresses) {
                    //Remove if there is an active home address
                    if ($address)
                        $address->delete();
                    //Restore the person's address home from the trash
                    $trashedAddresses->restore();
                } else {
                    if ($address) {
                        $address->fill($request->only($this->arrAddressFields));
                    } else {
                        $address = $addressVerify;
                    }
                    $person->addresses()->save($address);
                }
            } else {
                if ($address)
                    $address->delete();
            }

            //Update the person's contacts
            $arrContactFields = array_keys($this->arrContactTypeId);
            if ($request->anyFilled($arrContactFields)) {
                //Update the person's contacts
                foreach ($this->arrContactTypeId as $key => $value) {
                    $contact = $person->contacts->where('contact_type_id', $value)->first();
                    if ($request->filled($key)) {
                        $contactType = ContactType::find($value);
                        $contactVerify = new Contact();
                        $contactVerify->contactType()->associate($contactType);
                        $contactVerify->value = $request->$key;

                        //Checks if the person's contacts is in the trash
                        $trashedContact = Contact::onlyTrashed()
                            ->where('contact_type_id', $value)
                            ->where('value', $request->$key)
                            ->where('person_id', $person->id)
                            ->first();
                        if ($trashedContact) {
                            //Remove if there is an active contact
                            if ($contact)
                                $contact->delete();
                            //Restore the person's address home from the trash
                            $trashedContact->restore();
                        } else {
                            if ($contact) {
                                $contact->value = $request->$key;
                            } else {
                                $contact = $contactVerify;
                            }
                            $person->contacts()->save($contact);
                        }
                    } else {
                        if ($contact)
                            $contact->delete();
                    }
                }
            } else {
                foreach ($person->contacts as $contact) {
                    $contact->delete();
                }
            }
            $person->save();
            return $person;
        });
        return (object) $person->toArray();
    }
}
