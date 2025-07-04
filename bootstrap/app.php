<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureOrderNotPaid;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'paytabs/*',
            'payment/success',
            'payment/callback',
            'payment/return'
        ]);

        $middleware->alias([
            'ensureOrderNotPaid' => EnsureOrderNotPaid::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
