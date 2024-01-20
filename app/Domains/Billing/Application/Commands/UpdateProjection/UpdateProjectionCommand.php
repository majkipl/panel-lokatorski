<?php

namespace App\Domains\Billing\Application\Commands\UpdateProjection;

use App\Interfaces\Command\Command;

class UpdateProjectionCommand extends Command
{
    /**
     * @param string $uuid
     * @param string $projection
     */
    public function __construct(
        private readonly string $uuid,
        private readonly string $projection
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

    /**
     * @return string
     */
    public function getProjection(): string
    {
        return $this->projection;
    }
}
