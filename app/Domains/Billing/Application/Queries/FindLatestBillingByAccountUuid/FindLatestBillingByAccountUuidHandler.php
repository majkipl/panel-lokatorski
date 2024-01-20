<?php

namespace App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid;

use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;

class FindLatestBillingByAccountUuidHandler
{
    /**
     * @param BillingRepositoryInterface $repository
     */
    public function __construct(protected BillingRepositoryInterface $repository)
    {
    }


    /**
     * @param FindLatestBillingByAccountUuidQuery $query
     * @return string
     */
    public function handle(FindLatestBillingByAccountUuidQuery $query): string
    {
        return $this->repository->getLatestByAccountUuid($query->getUuid())->projection ?? serialize([]);
    }
}
