<?php

namespace App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class FindAccountsUuidByUserRoleAndStatusHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param FindAccountsUuidByUserRoleAndStatusQuery $query
     * @return array
     */
    public function handle(FindAccountsUuidByUserRoleAndStatusQuery $query): array
    {
        return $this->repository->getAccountByUserRoleAndStatus(
            status: $query->getStatus(),
            role: $query->getRole()
        )->pluck('uuid')->toArray();
    }
}
