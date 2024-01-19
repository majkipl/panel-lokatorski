<?php

namespace App\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected User $model)
    {
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $role
     * @param string|null $status
     * @return Collection
     */
    public function getUsersByStatusAndRole(array $role, ?string $status = null): Collection
    {
        return $this->model->when(!is_null($status), function ($query) use ($status) {
            return $query->where('status', $status);
        })->whereIn('role', $role)->get();
    }

    /**
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool
    {
        $user = $this->model->find($id);
        $user->status = $status;
        return $user->save();
    }

    /**
     * @param int $id
     * @return Account
     */
    public function getAccountByUserId(int $id): Account
    {
        return $this->model->find($id)->account;
    }

    /**
     * @param int $id
     * @param string $name
     * @param float $amount
     * @return void
     */
    public function addExpense(int $id, string $name, float $amount): void
    {
        $this->model->find($id)->account->addExpense($name, $amount);
    }

    /**
     * @param int $id
     * @param float $amount
     * @return void
     */
    public function addMoney(int $id, float $amount): void
    {
        $this->model->find($id)->account->addMoney($amount);
    }

    /**
     * @param int $id
     * @param float $amount
     * @return void
     */
    public function subtractMoney(int $id, float $amount): void
    {
        $this->model->find($id)->account->subtractMoney($amount);
    }

    /**
     * @param UserDTO $dto
     * @return bool
     */
    public function create(UserDTO $dto): bool
    {
        $this->model->email = $dto->email;
        $this->model->firstname = $dto->firstname;
        $this->model->lastname = $dto->lastname;
        $this->model->password = $dto->password;
        $this->model->status = $dto->status;
        $this->model->role = $dto->role;
        $this->model->email_verified_at = $dto->email_verified_at;
        $this->model->remember_token = $dto->remember_token;
        $this->model->created_at = $dto->created_at;
        $this->model->updated_at = $dto->updated_at;
        $this->model->last_login_at = $dto->last_login_at;
        return $this->model->save();
    }
}
