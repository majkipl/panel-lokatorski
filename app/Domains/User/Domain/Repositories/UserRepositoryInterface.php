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
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool;

    /**
     * @param UserDTO $dto
     * @return bool
     */
    public function create(UserDTO $dto): bool;
}
