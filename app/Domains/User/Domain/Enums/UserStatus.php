<?php

namespace App\Domains\User\Domain\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
