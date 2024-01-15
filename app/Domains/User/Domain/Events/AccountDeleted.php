<?php

namespace App\Domains\User\Domain\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AccountDeleted extends ShouldBeStored
{
    /**
     * @param string $accountUuid
     */
    public function __construct(public string $accountUuid)
    {
    }
}
