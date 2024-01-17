<?php

namespace App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;

class FindLatestPaymentByAccountUuidHandler
{
    /**
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(protected PaymentRepositoryInterface $repository)
    {
    }

    /**
     * @param FindLatestPaymentByAccountUuidQuery $query
     * @return string
     */
    public function handle(FindLatestPaymentByAccountUuidQuery $query): string
    {
        return $this->repository->getLatestByAccountUuid($query->getUuid())->projection ?? serialize([]);
    }
}
