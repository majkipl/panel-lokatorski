<?php

namespace App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class FindEmailsByUserRoleAndStatusHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param FindEmailsByUserRoleAndStatusQuery $query
     * @return array
     */
    public function handle(FindEmailsByUserRoleAndStatusQuery $query): array
    {
        $users =  $this->repository->getUsersByStatusAndRole(
            role: $query->getRole(),
            status: $query->getStatus()->value
        );

        return $users->pluck('email')->toArray();
    }
}
