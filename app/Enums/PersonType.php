<?php

namespace App\Enums;

enum PersonType: string
{
    case F = "Física";
    case J = "Jurídica";

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
