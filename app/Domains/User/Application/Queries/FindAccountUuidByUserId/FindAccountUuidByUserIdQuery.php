<?php

namespace App\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Interfaces\Query\Query;

class FindAccountUuidByUserIdQuery extends Query
{
    /**
     * @param int $id
     */
    public function __construct(
        private readonly int $id
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
