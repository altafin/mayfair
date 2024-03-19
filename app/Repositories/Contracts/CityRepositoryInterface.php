<?php

namespace App\Repositories\Contracts;

interface CityRepositoryInterface
{
    public function getAll(string $state = null): array|null;
}
