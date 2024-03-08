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
use League\CommonMark\Extension\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor;
use stdClass;

class PersonRepository implements PersonRepositoryInterface
{
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
                $arrDocumentTypeId = array('F' => 1, 'J' => 2);
                $documentTypeId = $arrDocumentTypeId[$request->type];
                $documentType = DocumentType::find($documentTypeId);
                $document = new Document();
                $document->value = $request->document;
                $document->documentType()->associate($documentType);
                $person->documents()->save($document);
            }
            //Bind with Addresses
            $arrAddressFields = array('zip_code', 'street', 'number', 'complement', 'uf', 'city', 'district', 'reference');
            if ($request->anyFilled($arrAddressFields)) {
                $addressType = AddressType::find(1);
                $address = new Address($request->only($arrAddressFields));
                $address->addressType()->associate($addressType);
                $person->addresses()->save($address);
            }
            //Bind with Contacts
            $arrContactTypeId = array('email' => 1, 'phone' => 2, 'cell' => 3, 'website' => 4);
            $arrContactFields = array_keys($arrContactTypeId);
            if ($request->anyFilled($arrContactFields)) {
                foreach ($arrContactTypeId as $field => $contactTypeId) {
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
        if (!$person = $this->model->find($id)) {
            return null;
        }
        $person->update($request->all());
        return (object) $person->toArray();
    }
}
