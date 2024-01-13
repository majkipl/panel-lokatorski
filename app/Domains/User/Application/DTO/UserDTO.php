<?php

namespace App\Domains\User\Application\DTO;

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Carbon\Carbon;

class UserDTO
{
    /**
     * @param string $email
     * @param string $firstname
     * @param string $lastname
     * @param string $password
     * @param UserStatus $status
     * @param UserRole $role
     * @param string|null $email_verified_at
     * @param string|null $remember_token
     * @param Carbon|null $created_at
     * @param string|null $updated_at
     * @param string|null $last_login_at
     */
    public function __construct(
        public string      $email,
        public string      $firstname,
        public string      $lastname,
        public string      $password,
        public UserStatus  $status,
        public UserRole    $role,
        public string|null $email_verified_at = null,
        public string|null $remember_token = null,
        public Carbon|null $created_at = null,
        public string|null $updated_at = null,
        public string|null $last_login_at = null
    )
    {
    }

}
