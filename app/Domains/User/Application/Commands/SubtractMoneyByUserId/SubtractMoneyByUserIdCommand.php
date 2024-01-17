<?php

namespace App\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Interfaces\Command\Command;

class SubtractMoneyByUserIdCommand extends Command
{
    /**
     * @param int $id
     * @param float $amount
     */
    public function __construct(
        private readonly int $id,
        private readonly float $amount
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
    public function getAmount(): float
    {
        return $this->amount;
    }

}
