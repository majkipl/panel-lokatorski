<?php

namespace App\Domains\User\Domain\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * @param UserDTO $dto
     * @return bool
     */
    public function create(UserDTO $dto): bool;
}
