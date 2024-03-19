<?php

namespace App\Repositories;

use App\Models\Region;
use App\Repositories\Contracts\RegionRepositoryInterface;

class RegionRepository implements RegionRepositoryInterface
{
    public function __construct(
        protected Region $model
    ) {}

    public function getAll(): array
    {
        $regions = $this->model::all();
        return $regions->toArray();
    }
}
