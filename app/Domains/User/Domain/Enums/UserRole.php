<?php

namespace App\Domains\User\Domain\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';
}
