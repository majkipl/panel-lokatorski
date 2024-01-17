<?php

namespace App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Interfaces\Query\Query;

class FindLatestPaymentByAccountUuidQuery extends Query
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
