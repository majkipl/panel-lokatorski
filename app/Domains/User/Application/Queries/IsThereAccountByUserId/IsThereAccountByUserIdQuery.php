<?php

namespace App\Domains\User\Application\Queries\IsThereAccountByUserId;

use App\Interfaces\Query\Query;

class IsThereAccountByUserIdQuery extends Query
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
