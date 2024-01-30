<?php

namespace App\Services;

use App\DTO\Person\CreatePersonDTO;
use App\DTO\Person\UpdatePersonDTO;
use App\Http\Requests\StoreUpdatePersonRequest;
use App\Repositories\Contracts\PersonRepositoryInterface;
use stdClass;
class PersonService
{
    public function __construct(
        protected PersonRepositoryInterface $repository
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function new(StoreUpdatePersonRequest $request): stdClass
    {
        return $this->repository->new($request);
    }

    public function update(StoreUpdatePersonRequest $request): stdClass|null
    {
        return $this->repository->update($request);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
