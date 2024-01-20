<?php

namespace App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid;

use App\Interfaces\Query\Query;

class FindLatestBillingByAccountUuidQuery extends Query
{
    /**
     * @param string $uuid
     */
    public function __construct(
        private readonly string $uuid
    )
    {
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

}
