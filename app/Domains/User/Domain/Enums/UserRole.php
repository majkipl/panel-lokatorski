<?php

namespace App\Domains\User\Domain\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';

    public static function random(): self
    {
        $values = self::cases();
        $key = array_rand($values);
        return $values[$key];
    }
}
