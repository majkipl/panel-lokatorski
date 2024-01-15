<?php

namespace App\Providers;

use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
