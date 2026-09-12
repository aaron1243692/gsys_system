<?php

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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('signin'));
        $middleware->alias(['portal' => App\Http\Middleware\PortalAccess::class]);
        $middleware->web(append: [App\Http\Middleware\SeparatePortalAccess::class]);
        $middleware->prependToPriorityList(
            \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
            App\Http\Middleware\SeparatePortalAccess::class,
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
