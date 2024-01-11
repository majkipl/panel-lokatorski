<?php

namespace App\Providers;

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserRoleGateServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->defineUserRoleGate('isAdmin', UserRole::ADMIN->value);
        $this->defineUserRoleGate('isUser', UserRole::USER->value);
        $this->defineUserRoleGate('isGuest', UserRole::GUEST->value);
    }

    /**
     * @param string $name
     * @param string $role
     * @return void
     */
    private function defineUserRoleGate(string $name, string $role): void
    {
        Gate::define($name, function (User $user) use ($role) {
            return $user->role == $role;
        });
    }
}
