<?php

namespace App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Interfaces\Query\Query;

class FindAccountsUuidByUserRoleAndStatusQuery extends Query
{
    /**
     * @param string $status
     * @param array $role
     */
    public function __construct(
        private readonly string $status,
        private readonly array $role
    )
    {
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getRole(): array
    {
        return $this->role;
    }

}
