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
            'site' => fn () => [
                'name' => config('nymak.short_name'),
                'legal_name' => config('nymak.legal_name'),
                'tagline' => config('nymak.tagline'),
                'phone' => config('nymak.phone'),
                'phone_href' => config('nymak.phone_href'),
                'whatsapp' => config('nymak.whatsapp'),
                'email' => config('nymak.email'),
                'address' => config('nymak.address'),
                'branch_address' => config('nymak.branch_address'),
                'offices' => config('nymak.offices'),
                'socials' => array_filter(config('nymak.socials')),
            ],
            'nav' => fn () => [
                'categories' => \App\Models\ProductCategory::orderBy('sort_order')
                    ->get(['name', 'slug'])
                    ->map(fn ($c) => ['name' => $c->name, 'href' => "/products/{$c->slug}"]),
            ],
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
