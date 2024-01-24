<?php

namespace App\Domains\User\Application\Commands\UpdateBalanceByUserId;

use App\Interfaces\Command\Command;

class UpdateBalanceByUserIdCommand extends Command
{
    /**
     * @param int $id
     * @param float $balance
     */
    public function __construct(
        private readonly int $id,
        private readonly float $balance = 0,
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

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }
}
