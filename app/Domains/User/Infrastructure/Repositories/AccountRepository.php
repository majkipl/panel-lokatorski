<?php

namespace App\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Account $model)
    {
    }

    /**
     * @param string $uuid
     * @param int $id
     * @return void
     */
    public function cancelExpense(string $uuid, int $id): void
    {
        $this->model->where('uuid', $uuid)->first()->cancelExpense($id);
    }

    /**
     * @param string $uuid
     * @return User
     */
    public function getUserByAccountUuid(string $uuid): User
    {
        return $this->model->where('uuid', $uuid)
            ->with('user:id,firstname,lastname,email,created_at')
            ->first()
            ->user;
    }

    /**
     * @param string $status
     * @param array $role
     * @return Collection
     */
    public function getAccountByUserRoleAndStatus(string $status, array $role): Collection
    {
        return $this->model->whereHas('user', function ($query) use ($status, $role) {
            $query->whereIn('role', $role)
                ->where('status', $status);
        })->get();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isExistAccountByUserId(int $id): bool
    {
        return $this->model->where('user_id', $id)->exists();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function save(array $attributes = []): bool
    {
        return (new Account($attributes))->writeable()->save();
    }

    /**
     * @param int $id
     * @param float $balance
     * @return bool
     */
    public function updateBalanceByUserId(int $id, float $balance): bool
    {
        $account = $this->model->where('user_id', $id)->first();
        $account->balance = $balance;
        return $account->writeable()->save();
    }
}
