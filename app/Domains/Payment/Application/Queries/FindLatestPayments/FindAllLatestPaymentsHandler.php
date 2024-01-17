<?php

namespace App\Domains\Payment\Application\Queries\FindLatestPayments;

use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Carbon\Carbon;

class FindAllLatestPaymentsHandler
{
    /**
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(protected PaymentRepositoryInterface $repository)
    {
    }

    /**
     * @param FindAllLatestPaymentsQuery $query
     * @return array
     */
    public function handle(FindAllLatestPaymentsQuery $query): array
    {
        $latestPayments = $this->repository->getLatest();

        $payments = [];
        foreach ($latestPayments as $latestPayment) {
            $payments = array_merge($payments, unserialize($latestPayment->projection));
        }

        usort($payments, function ($a, $b) {
            return Carbon::parse($b['created_at']) <=> Carbon::parse($a['created_at']);
        });

        return $payments;
    }
}
