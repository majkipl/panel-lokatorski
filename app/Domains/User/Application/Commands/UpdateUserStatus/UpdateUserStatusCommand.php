<?php

namespace App\Domains\User\Application\Commands\UpdateUserStatus;

use App\Interfaces\Command\Command;

class UpdateUserStatusCommand extends Command
{
    /**
     * @param int $id
     * @param string $status
     */
    public function __construct(
        private readonly int $id,
        private readonly string $status
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
    public function getStatus(): string
    {
        return $this->status;
    }
}
