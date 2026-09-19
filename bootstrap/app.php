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
        $middleware->alias([
            'portal' => App\Http\Middleware\PortalAccess::class,
            'mobile' => App\Http\Middleware\MobileApiAuth::class,
        ]);
        $middleware->web(append: [App\Http\Middleware\SeparatePortalAccess::class]);
        $middleware->prependToPriorityList(
            \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
            App\Http\Middleware\SeparatePortalAccess::class,
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) return response()->json([
                'success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors(),
            ], 422);
        });
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) return response()->json([
                'success' => false, 'message' => $e->getMessage() ?: \Symfony\Component\HttpFoundation\Response::$statusTexts[$e->getStatusCode()] ?? 'Request failed.',
            ], $e->getStatusCode());
        });
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) return response()->json([
                'success' => false, 'message' => 'GSYS encountered a server error.',
            ], 500);
        });
    })->create();
