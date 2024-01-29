<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\StoreUpdatePersonRequest;
use App\DTO\Person\{
    CreatePersonDTO,
    UpdatePersonDTO
};
use stdClass;

interface PersonRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(StoreUpdatePersonRequest $dto): stdClass;
    public function update(UpdatePersonDTO $dto): stdClass|null;

}
