<?php

namespace App\Domains\User\Domain\Repositories;

use App\Domains\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    /**
     * @param string $uuid
     * @param int $id
     * @return void
     */
    public function cancelExpense(string $uuid, int $id): void;

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

    /**
     * @param int $id
     * @return bool
     */
    public function isExistAccountByUserId(int $id): bool;

    /**
     * @param array $attributes
     * @return bool
     */
    public function save(array $attributes = []): bool;

    /**
     * @param int $id
     * @param float $balance
     * @return bool
     */
    public function updateBalanceByUserId(int $id, float $balance): bool;
}
