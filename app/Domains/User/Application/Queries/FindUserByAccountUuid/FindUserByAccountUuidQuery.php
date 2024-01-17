<?php

namespace App\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Interfaces\Query\Query;

class FindUserByAccountUuidQuery extends Query
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
