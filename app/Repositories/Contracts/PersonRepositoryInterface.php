<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\StoreUpdatePersonRequest;
use stdClass;

interface PersonRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function getPaginate(int $page = 1, int $totalPerPage = 15, string $filter = null);
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(StoreUpdatePersonRequest $request, string $model): stdClass;
    public function update(StoreUpdatePersonRequest $request, string $id): stdClass|null;

}
