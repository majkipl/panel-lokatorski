<?php

namespace App\Domains\User\Domain\Repositories;

use App\Domains\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    /**
     * @param string $uuid
     * @return User
     */
    public function getUserByAccountUuid(string $uuid): User;

    /**
     * @param string $status
     * @param array $role
     * @return Collection
     */
    public function getAccountByUserRoleAndStatus(string $status, array $role): Collection;

}
