<?php

namespace App\Repositories;

use App\Models\State;
use App\Repositories\Contracts\StateRepositoryInterface;

class StateRepository implements StateRepositoryInterface
{
    public function __construct(
        protected State $model
    ) {}

    public function getAll(string $state = null, string $region = null): array|null
    {
        $states = $this->model::with('region')->where('states.name', 'LIKE', "%$state%")->get();
        return $states->toArray();
    }
}
