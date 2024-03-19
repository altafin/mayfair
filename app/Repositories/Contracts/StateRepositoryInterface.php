<?php

namespace App\Repositories\Contracts;

interface StateRepositoryInterface
{
    public function getAll(string $region = null): array|null;
}
