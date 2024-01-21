<?php

namespace App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid;

use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;

class FindLatestBalanceByAccountUuidHandler
{
    /**
     * @param BalanceRepositoryInterface $repository
     */
    public function __construct(protected BalanceRepositoryInterface $repository)
    {
    }


    /**
     * @param FindLatestBalanceByAccountUuidQuery $query
     * @return string
     */
    public function handle(FindLatestBalanceByAccountUuidQuery $query): string
    {
        return $this->repository->getLatestByAccountUuid($query->getUuid())->projection ?? serialize([]);
    }
}
