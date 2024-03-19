<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    public function __construct(
        protected City $model
    ) {}

    public function getAll(string $state = null): array|null
    {
        $cities = $this->model::where('state_id', $state)->get();
        return $cities->toArray();
    }
}
