<?php

namespace App\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Interfaces\Query\Query;

class FindUsersByStatusAndRoleQuery extends Query
{
    /**
     * @param string|null $status
     * @param array $role
     */
    public function __construct(
        private readonly array $role,
        private readonly ?string $status = null
    )
    {
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
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
