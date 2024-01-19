<?php

namespace App\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Interfaces\Command\Command;

class AddExpenseByUserIdCommand extends Command
{
    /**
     * @param int $id
     * @param string $name
     * @param float $amount
     */
    public function __construct(
        private readonly int $id,
        private readonly string $name,
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

}
