<?php

namespace App\Enums;

enum ContactType
{
    const EMAIL = 1;
    const PHONE = 2;
    const CELL = 3;
    const WEBSITE = 4;
    public static function fromValue(string $name): string
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }

        throw new \ValueError("$status is not a valid");
    }
}
