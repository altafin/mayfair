<?php

namespace App\DTO\Person;

use App\Http\Requests\StoreUpdatePersonRequest;

class CreatePersonDTO
{
    public function __construct(
        public string $name,
        public string $type,
    ) {}

    public static function makeFromRequest(StoreUpdatePersonRequest $request): self
    {
        return new self($request->name, $request->type);
    }

}
