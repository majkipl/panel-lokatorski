<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(SingletonServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->register(DomainServiceProvider::class);
        $this->app->register(CommandHandlerServiceProvider::class);
        $this->app->register(QueryHandlerServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(UserRoleGateServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
    }
}
