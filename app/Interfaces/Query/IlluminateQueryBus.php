<?php

namespace App\Interfaces\Query;

use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
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
     * @param Query $query
     * @return mixed
     */
    public function ask(Query $query): mixed
    {
        return $this->bus->dispatch($query);
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
