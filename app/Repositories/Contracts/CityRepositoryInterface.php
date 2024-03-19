<?php

namespace App\Repositories\Contracts;

interface CityRepositoryInterface
{
    public function getAll(string $state = null, string $city = null): array|null;
}
