<?php

namespace App\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class FindAccountUuidByUserIdHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param FindAccountUuidByUserIdQuery $query
     * @return string
     */
    public function handle(FindAccountUuidByUserIdQuery $query): string
    {
        return $this->repository->getAccountByUserId(
            id: $query->getId()
        )->uuid;
    }
}
