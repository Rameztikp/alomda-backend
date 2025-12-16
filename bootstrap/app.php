cd d:\alomda\alomda-backend
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        // Do not trust all hosts as a literal '*' pattern —
        // passing '*' becomes an invalid regex ("{*}i") in Symfony's Request.
        // Let the middleware use the application URL (app.url) to build trusted host
        // patterns by calling trustHosts() with no explicit patterns.
        $middleware->trustHosts();
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();