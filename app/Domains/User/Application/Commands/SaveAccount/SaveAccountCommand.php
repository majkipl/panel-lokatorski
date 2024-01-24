<?php

namespace App\Domains\User\Application\Commands\SaveAccount;

use App\Interfaces\Command\Command;

class SaveAccountCommand extends Command
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes = []
    )
    {
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
