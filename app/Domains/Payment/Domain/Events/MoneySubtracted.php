<?php

namespace App\Domains\Payment\Domain\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class MoneySubtracted extends ShouldBeStored
{
    /**
     * @param string $accountUuid
     * @param float $amount
     */
    public function __construct(public string $accountUuid, public float $amount)
    {
    }
}
