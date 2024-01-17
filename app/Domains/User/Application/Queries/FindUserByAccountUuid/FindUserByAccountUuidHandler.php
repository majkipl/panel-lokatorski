<?php

namespace App\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class FindUserByAccountUuidHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param FindUserByAccountUuidQuery $query
     * @return User
     */
    public function handle(FindUserByAccountUuidQuery $query): User
    {
        return $this->repository->getUserByAccountUuid(
            uuid: $query->getUuid()
        );
    }
}
