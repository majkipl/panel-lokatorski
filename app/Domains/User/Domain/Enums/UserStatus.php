<?php

namespace App\Domains\User\Domain\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function random(): self
    {
        $values = self::cases();
        $key = array_rand($values);
        return $values[$key];
    }
}
