<?php

namespace App\Interfaces\Command;

use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    /**
     * @param Dispatcher $bus
     */
    public function __construct(
        protected Dispatcher $bus
    )
    {
    }

    /**
     * @param Command $command
     * @return mixed
     */
    public function dispatch(Command $command): mixed
    {
        return $this->bus->dispatch($command);
    }

    /**
     * @param array $map
     * @return void
     */
    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
