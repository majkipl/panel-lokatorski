<?php

namespace App\Domains\Expense\Domain\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ExpenseAdded extends ShouldBeStored
{
    /**
     * @param string $accountUuid
     * @param string $name
     * @param float $amount
     * @param array $participants
     */
    public function __construct(
        public string $accountUuid,
        public string $name,
        public float $amount,
        public array $participants = []
    )
    {
    }
}
