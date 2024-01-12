<?php

namespace App\Interfaces\Query;

interface QueryBus
{
    /**
     * @param Query $query
     * @return mixed
     */
    public function ask(Query $query): mixed;

    /**
     * @param array $map
     * @return void
     */
    public function register(array $map): void;
}
