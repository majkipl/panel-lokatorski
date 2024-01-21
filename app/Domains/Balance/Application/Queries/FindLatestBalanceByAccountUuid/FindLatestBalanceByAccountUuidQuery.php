<?php

namespace App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid;

use App\Interfaces\Query\Query;

class FindLatestBalanceByAccountUuidQuery extends Query
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
