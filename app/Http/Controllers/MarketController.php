<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Markets/Index', [
            'seo' => Seo::make(
                'Global Presence — Pharmaceutical Exports to 24+ Countries',
                'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific.'
            )->breadcrumbs([
                ['Home', url('/')],
                ['Global Presence', url('/global-presence')],
            ])->toArray(),
            'markets' => Market::orderBy('sort_order')->get(),
            'offices' => config('nymak.offices'),
        ]);
    }

    public function show(Market $market): Response
    {
        // Requirement #9: only markets with real, distinct content get pages.
        abort_unless($market->has_page, 404);

        $market->load(['products' => fn ($q) => $q->where('has_detail_page', true)
            ->with('category:id,slug')
            ->select('id', 'market_id', 'product_category_id', 'name', 'slug', 'description', 'image')]);

        $office = collect(config('nymak.offices'))
            ->first(fn ($o) => strtoupper($o['country_code'] ?? '') === strtoupper($market->iso_code ?? ''));

        return Inertia::render('Markets/Show', [
            'seo' => Seo::make(
                "Pharmaceutical Exports to {$market->name}",
                $market->description
                    ?? "Nymak Pharma supplies WHO-GMP certified pharmaceuticals to {$market->name} — IV fluids, formulations, devices and diagnostics."
            )->breadcrumbs([
                ['Home', url('/')],
                ['Global Presence', url('/global-presence')],
                [$market->name, url("/global-presence/{$market->slug}")],
            ])->toArray(),
            'market' => $market->only('name', 'slug', 'region', 'description'),
            'office' => $office,
            'products' => $market->products->map(fn ($p) => [
                'name' => $p->name,
                'description' => $p->description,
                'image' => $p->image,
                'url' => url("/products/{$p->category->slug}/{$p->slug}"),
            ]),
        ]);
    }
}
