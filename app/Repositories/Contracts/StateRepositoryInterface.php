<?php

namespace App\Repositories\Contracts;

interface StateRepositoryInterface
{
    public function getAll(string $state = null, string $region = null): array|null;
}
