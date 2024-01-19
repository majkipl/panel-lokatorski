<?php

namespace App\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Interfaces\Query\Query;

class FindAllByAccountUuidQuery extends Query
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
