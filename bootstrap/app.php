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
        $middleware->web(prepend: [
            \App\Http\Middleware\NormalizeUrls::class,
        ], append: [
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
            $titles = [
                401 => 'Sign In Required',
                402 => 'Payment Required',
                403 => 'Access Restricted',
                404 => 'Page Not Found',
                405 => 'Method Not Allowed',
                408 => 'Request Timeout',
                419 => 'Session Expired',
                422 => 'Unprocessable Request',
                429 => 'Too Many Requests',
                500 => 'Error',
                503 => 'Maintenance',
            ];
            if (! isset($titles[$status]) || $request->expectsJson()) {
                return $response;
            }
            // Keep the framework's debug exception page for real 500s in dev.
            if ($status === 500 && config('app.debug') && ! app()->runningUnitTests()) {
                return $response;
            }

            // Route middleware never ran for these errors (unmatched routes, or
            // exceptions thrown before HandleInertiaRequests) so shared props
            // like `site`/`nav` are absent — provide them explicitly or the
            // layout crashes on missing site settings. Resolve each defensively:
            // a missing session or DB must not break the error page itself.
            $shared = [];
            foreach (app(\App\Http\Middleware\HandleInertiaRequests::class)->share($request) as $key => $value) {
                try {
                    $shared[$key] = $value instanceof \Closure ? $value() : $value;
                } catch (\Throwable) {
                }
            }

            return \Inertia\Inertia::render('Error', $shared + [
                'status' => $status,
                'seo' => ['title' => $titles[$status], 'robots' => 'noindex'],
            ])->toResponse($request)->setStatusCode($status);
        });
    })->create();
