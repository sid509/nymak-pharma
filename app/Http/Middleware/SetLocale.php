<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public-site locale from the URL prefix: `/fr/…`, `/es/…` — English is the
 * canonical unprefixed variant. URL::defaults makes every `route()` call in
 * this request emit the matching prefix automatically (links, redirects,
 * canonicals, sitemap).
 */
class SetLocale
{
    public const LOCALES = ['en', 'fr', 'es'];

    public const LABELS = ['en' => 'English', 'fr' => 'Français', 'es' => 'Español'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale') ?? 'en';
        app()->setLocale($locale);
        URL::defaults(['locale' => $locale === 'en' ? null : $locale]);

        // Strip the prefix param so implicit model bindings stay positional —
        // otherwise show(ProductCategory $category) receives 'fr' as arg 1.
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }

    /**
     * The site-relative URL for `$path` in `$locale` (default: current locale).
     * English is unprefixed; others get `/fr`, `/es`, `/fr/about`, …
     */
    public static function url(string $path, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $path = trim($path, '/');

        return $locale === 'en' ? "/{$path}" : "/{$locale}" . ($path !== '' ? "/{$path}" : '');
    }

    /** Absolute URL for `$path` in `$locale` (default: current locale). */
    public static function absolute(string $path, ?string $locale = null): string
    {
        return url(self::url($path, $locale));
    }
}
