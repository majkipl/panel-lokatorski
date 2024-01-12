<?php

namespace App\Domains\User\Application\Queries\FindAllUsers;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FindAllUsersHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param FindAllUsersQuery $query
     * @return Collection
     */
    public function handle(FindAllUsersQuery $query): Collection
    {
        return $this->repository->getAllUsers();
    }
}
