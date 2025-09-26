<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'verify_csrf_token' => \App\Http\Middleware\VerifyCsrfToken::class,  // yahan add karo
        ]);
        
    })
    ->withSchedule(function (Schedule $schedule) {
        // Billing cron job daily
        $schedule->command('billing:process')->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
