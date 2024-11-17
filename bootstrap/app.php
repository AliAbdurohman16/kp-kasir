<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\MidtransConfig;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user-access' => \App\Http\Middleware\UserAccess::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        ]);
        $middleware->append(MidtransConfig::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
