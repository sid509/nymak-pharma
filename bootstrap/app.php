<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->redirectGuestsTo('/admin/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Render branded Inertia error pages for HTTP errors.
        $exceptions->respond(function ($response, $e, Request $request) {
            $status = $response->getStatusCode();
            if (! in_array($status, [404, 500, 503]) || $request->expectsJson()) {
                return $response;
            }

            return \Inertia\Inertia::render('Error', [
                'status' => $status,
                'seo' => ['title' => $status === 404 ? 'Page Not Found' : 'Error', 'robots' => 'noindex'],
            ])->toResponse($request)->setStatusCode($status);
        });
    })->create();
