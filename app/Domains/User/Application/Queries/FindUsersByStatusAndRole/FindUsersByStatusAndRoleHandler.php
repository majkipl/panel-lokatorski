<?php

namespace App\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FindUsersByStatusAndRoleHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param FindUsersByStatusAndRoleQuery $query
     * @return Collection
     */
    public function handle(FindUsersByStatusAndRoleQuery $query): Collection
    {
        return $this->repository->getUsersByStatusAndRole(
            role: $query->getRole(),
            status: $query->getStatus()
        );
    }
}
