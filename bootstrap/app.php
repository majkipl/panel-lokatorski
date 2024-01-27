<?php

use App\Domains\Auth\Application\Middlewares\InRolesMiddleware;
use App\Domains\Auth\Application\Middlewares\OnlyGuestAllowedMiddleware;
use App\Domains\Auth\Application\Middlewares\RoleMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'inRoles' => InRolesMiddleware::class,
            'guest' => OnlyGuestAllowedMiddleware::class
        ]);
    })
    ->withCommands(
        commands: glob(Application::getInstance()->path('Domains/*/Application/Consoles'), GLOB_ONLYDIR)
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('email:send-daily-expenses')->daily()->at('23:30');

        $schedule->command('email:send-monthly-billing')
            ->monthly()
            ->when(function () {
                return now()->endOfMonth()->isToday();
            })
            ->at('23:00');
    })
    ->withEvents(
        discover: glob(Application::getInstance()->path('Domains/*/*/Listeners'), GLOB_ONLYDIR)
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
