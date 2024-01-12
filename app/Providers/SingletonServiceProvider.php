<?php

namespace App\Providers;

use App\Interfaces\Command\CommandBus;
use App\Interfaces\Command\IlluminateCommandBus;
use App\Interfaces\Query\IlluminateQueryBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Support\ServiceProvider;

class SingletonServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $singletons = [
            CommandBus::class => IlluminateCommandBus::class,
            QueryBus::class => IlluminateQueryBus::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
