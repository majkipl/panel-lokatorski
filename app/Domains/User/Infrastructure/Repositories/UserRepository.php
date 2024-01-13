<?php

namespace App\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
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
