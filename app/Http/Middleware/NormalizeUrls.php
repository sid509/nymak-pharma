<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Canonical URL normalization for crawlers and users.
 *
 * - Trailing slashes are 301'd to the clean path (the old site served
 *   /product/iv-fluids/ — those indexed URLs must keep working).
 * - Known legacy paths resolve straight to their final destination in one
 *   hop instead of trailing-slash → route-redirect chains.
 */
class NormalizeUrls
{
    /** Legacy path (normalized, no trailing slash) => final canonical path. */
    private const LEGACY = [
        '/about-us' => '/about',
        '/contact-us' => '/contact',
        '/iv-fluid' => '/product/iv-fluids',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') || $request->isMethod('HEAD')) {
            $path = $request->getPathInfo();

            if ($path !== '/' && str_ends_with($path, '/')) {
                $normalized = rtrim($path, '/');
                $target = self::LEGACY[$normalized] ?? $normalized;

                $qs = $request->getQueryString();

                return redirect($target.($qs ? "?{$qs}" : ''), 301);
            }
        }

        return $next($request);
    }
}
