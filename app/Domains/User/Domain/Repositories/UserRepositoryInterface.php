<?php

namespace App\Domains\User\Domain\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * @param string|null $status
     * @param array $role
     * @return Collection
     */
    public function getUsersByStatusAndRole(array $role, ?string $status = null): Collection;

    /**
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool;

    /**
     * @param int $id
     * @return Account
     */
    public function getAccountByUserId(int $id): Account;

    /**
     * @param int $id
     * @param string $name
     * @param float $amount
     * @return void
     */
    public function addExpense(int $id, string $name, float $amount): void;

    /**
     * @param int $id
     * @param float $amount
     * @return void
     */
    public function addMoney(int $id, float $amount): void;

    /**
     * @param int $id
     * @param float $amount
     * @return void
     */
    public function subtractMoney(int $id, float $amount): void;

    /**
     * @param UserDTO $dto
     * @return bool
     */
    public function create(UserDTO $dto): bool;
}
