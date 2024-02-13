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
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\PersonRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                    $query->where('type', $filter);
                    $query->where('name', 'like', "%{$filter}%");
                }
            })
            ->get()
            ->toArray();
    }

    public function getPaginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('type', $filter);
                    $query->orWhere('name', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
        return new PaginationPresenter($result);
    }

    public function findOne(string $id): stdClass|null
    {
        $person = $this->model->find($id);
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
            $person->categories()->create(['name' => $model]);
            //Bind with Documents
            if ($request->filled('document')) {
                $TipoDocumento = null;
                switch ($request->type) {
                    case 'F':
                        $TipoDocumento = 1;
                        break;
                    case 'J':
                        $TipoDocumento = 2;
                        break;
                }
                $documentType = DocumentType::find($TipoDocumento);
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
            $arrContactFields = array('email', 'cell', 'phone', 'website');
            if ($request->anyFilled($arrContactFields)) {
                foreach ($arrContactFields as $field) {
                    if ($request->filled($field)) {
                        $tipoContato = null;
                        switch ($field) {
                            case 'email':
                                $tipoContato = 1;
                                break;
                            case 'phone':
                                $tipoContato = 2;
                                break;
                            case 'cell':
                                $tipoContato = 3;
                                break;
                            case 'website':
                                $tipoContato = 4;
                                break;
                        }
                        $contactType = ContactType::find($tipoContato);
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
