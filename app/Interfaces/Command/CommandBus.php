<?php

namespace App\Interfaces\Command;

interface CommandBus
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function dispatch(Command $command): mixed;

    /**
     * @param array $map
     * @return void
     */
    public function register(array $map): void;
}
