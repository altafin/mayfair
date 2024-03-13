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
use App\Repositories\Contracts\PersonRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class PersonRepository implements PersonRepositoryInterface
{
    private $arrDocumentTypeId = array('F' => 1, 'J' => 2);
    private $arrAddressFields = array('zip_code', 'street', 'number', 'complement', 'uf', 'city', 'district', 'reference');
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
        $person = $this->model->find($id);
        $person->documents->where('document_type_id', ($person->type == 'F' ? 1 : 2));
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
                $addressType = AddressType::find(1);
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
            if (!$person = $this->model->with(['documents'])->find($id)) {
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
            if ($document) {
                $documentTemp = $document;
                //Update the person's document temporary
                $documentTemp->value = $request->document;
                //Checks if the person's document has changed
                if ($documentTemp->isDirty(['value'])) {
                    if ($request->filled('document')) {
                        //Delete the old document
                        $document->delete();
                        //Create the person's new document
                        $document = new Document();
                        $document->value = $request->document;
                        $documentTypeId = $this->arrDocumentTypeId[$request->type];
                        $documentType = DocumentType::find($documentTypeId);
                        $document->documentType()->associate($documentType);
                        $person->documents()->save($document);
                    } else {
                        //You changed the type but did not fill in the field, so you must remove the old document
                        $document->delete();
                    }
                }
            } else {
                //Cria um novo documento caso não seja localizado nenhum anterior
                $document = new Document();
                $document->value = $request->document;
                $documentTypeId = $this->arrDocumentTypeId[$request->type];
                $documentType = DocumentType::find($documentTypeId);
                $document->documentType()->associate($documentType);
                $person->documents()->save($document);
            }
            $person->save();
            return $person;
        });
        return (object) $person->toArray();
    }
}
