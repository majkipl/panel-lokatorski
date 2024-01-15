<?php

namespace App\Domains\User\Infrastructure\Providers;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use App\Domains\User\Infrastructure\Repositories\AccountRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
    }
}
