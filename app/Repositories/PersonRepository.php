<?php

namespace App\Repositories;

use App\DTO\Person\CreatePersonDTO;
use App\DTO\Person\UpdatePersonDTO;
use App\Http\Requests\StoreUpdatePersonRequest;
use App\Models\Person;
use App\Repositories\Contracts\PersonRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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

    public function new(StoreUpdatePersonRequest $request): stdClass
    {
        $person = Auth::user()->people()->create($request->all());
        return (object) $person->toArray();
    }

    public function update(UpdatePersonDTO $dto): stdClass|null
    {
        if (!$person = $this->model->find($dto->id)) {
            return null;
        }
        $person->update((array) $dto);
        return (object) $person->toArray();
    }
}
