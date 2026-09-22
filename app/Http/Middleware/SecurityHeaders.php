<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Removes platform-identifying headers and sets baseline security headers.
 * X-Powered-By leaks the PHP version even when the host forgets expose_php=Off.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // X-Powered-By is emitted by PHP core (expose_php), outside the
        // Symfony response — must be cleared at the raw header layer.
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        $response = $next($request);

        $response->headers->remove('X-Powered-By');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
