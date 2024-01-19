<?php

namespace App\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Interfaces\Command\Command;

class CancelExpenseByAccountUuidCommand extends Command
{
    /**
     * @param string $uuid
     * @param int $id
     */
    public function __construct(
        private readonly string $uuid,
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

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
