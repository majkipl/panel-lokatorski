<?php

namespace App\Domains\User\Domain\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AccountCreated extends ShouldBeStored
{
    /**
     * @param array $accountAttributes
     */
    public function __construct(public array $accountAttributes)
    {
    }
}
