<?php

namespace App\Domains\User\Application\Queries\IsThereAccountByUserId;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class IsThereAccountByUserIdHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param IsThereAccountByUserIdQuery $query
     * @return bool
     */
    public function handle(IsThereAccountByUserIdQuery $query): bool
    {
        return $this->repository->isExistAccountByUserId(
            id: $query->getId()
        );
    }
}
