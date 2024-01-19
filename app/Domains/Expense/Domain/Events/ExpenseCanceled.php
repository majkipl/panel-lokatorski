<?php

namespace App\Domains\Expense\Domain\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExpenseCanceled extends ShouldBeStored
{
    /**
     * @param string $accountUuid
     * @param string $name
     * @param float $amount
     * @param int $eventId
     * @param array $participants
     */
    public function __construct(
        public string $accountUuid,
        public string $name,
        public float $amount,
        public int $eventId,
        public array $participants = []
    )
    {
    }
}
