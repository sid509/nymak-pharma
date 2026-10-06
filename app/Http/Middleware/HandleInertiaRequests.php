<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'site' => fn () => collect(\App\Models\SiteSetting::merged())->only(
                'short_name', 'legal_name', 'tagline', 'phone', 'phone_href',
                'whatsapp', 'tawk_property', 'email', 'address', 'branch_address', 'offices', 'socials',
                'founded', 'founder', 'logo', 'brochure'
            )->put('name', \App\Models\SiteSetting::get('short_name'))
                ->put('socials', array_filter(\App\Models\SiteSetting::get('socials', [])))
                ->put('logo_uploaded', \App\Models\SiteSetting::where('key', 'logo')->exists())
                ->all(),
            'nav' => fn () => [
                'categories' => \App\Models\ProductCategory::orderBy('sort_order')
                    ->withCount('products')
                    ->get(['id', 'name', 'slug', 'icon', 'i18n'])
                    ->map(fn ($c) => [
                        'name' => $c->trans('name'),
                        'href' => \App\Http\Middleware\SetLocale::url("product/{$c->slug}", app()->getLocale()),
                        'icon' => $c->icon,
                        'count' => $c->products_count,
                    ]),
            ],
            // Public-site locale (en/fr/es) — URL prefix via SetLocale.
            'locale' => fn () => app()->getLocale(),
            'i18n' => fn () => \App\Support\I18n::dict(app()->getLocale()),
            // Alternate URLs of this page in every locale (switcher + hreflang).
            'locales' => function () use ($request) {
                $path = preg_replace('#^(fr|es)(?=/|$)#', '', trim($request->path(), '/')) ?? '';
                $qs = $request->getQueryString();

                return collect(\App\Http\Middleware\SetLocale::LOCALES)
                    ->mapWithKeys(fn ($l) => [$l => \App\Http\Middleware\SetLocale::url($path, $l).($qs ? "?{$qs}" : '')])
                    ->all();
            },
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'auth' => fn () => [
                'user' => $request->user()?->only('name', 'email'),
            ],
            // Admin chrome data — guest requests short-circuit before the query.
            'admin' => fn () => [
                'unreadEnquiries' => $request->user() ? \App\Models\Enquiry::unread()->count() : 0,
            ],
        ];
    }
}
