<?php

namespace App\Domains\User\Infrastructure\Repositories;

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
}
