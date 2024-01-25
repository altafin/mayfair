<?php

namespace App\DTO\Person;

use App\Http\Requests\StoreUpdatePersonRequest;

class UpdatePersonDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
    ) {}

    public static function makeFromRequest(StoreUpdatePersonRequest $request): self
    {
        return new self($request->id, $request->name, $request->type);
    }

}
