<?php

namespace App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Interfaces\Query\Query;
use InvalidArgumentException;

class FindEmailsByUserRoleAndStatusQuery extends Query
{
    /**
     * @param UserStatus $status
     * @param array $role
     */
    public function __construct(
        private readonly UserStatus $status,
        private readonly array $role
    )
    {
        foreach ($this->role as $roleItem) {
            if (!in_array($roleItem, UserRole::cases())) {
                throw new InvalidArgumentException('Role must be an array of UserRole enums');
            }
        }
    }

    /**
     * @return string[]
     */
    public function getRole(): array
    {
        $roleValues = [];
        foreach ($this->role as $roleItem) {
            $roleValues[] = $roleItem->value;
        }
        return $roleValues;
    }

    /**
     * @return UserStatus
     */
    public function getStatus(): UserStatus
    {
        return $this->status;
    }

}
