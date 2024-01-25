<?php

namespace App\Services;

use App\DTO\Person\CreatePersonDTO;
use App\DTO\Person\UpdatePersonDTO;
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

    public function new(CreatePersonDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdatePersonDTO $dto): stdClass
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
