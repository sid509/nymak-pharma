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
        // Portfolio model: markets show *what we actually did* there — the
        // products supplied — instead of thin per-country pages.
        $markets = Market::where('show_in_portfolio', true)
            ->orderBy('sort_order')
            ->with(['products' => fn ($q) => $q->where('has_detail_page', true)
                ->with('category:id,slug')
                ->select('id', 'market_id', 'product_category_id', 'name', 'slug', 'image')])
            ->get();

        return Inertia::render('Markets/Index', [
            'seo' => Seo::make(
                'Global Presence — Pharmaceutical Exports to 24+ Countries',
                'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific.'
            )->override('markets.index')->breadcrumbs([
                ['Home', url('/')],
                ['Global Presence', url('/global-presence')],
            ])->toArray(),
            'markets' => Market::orderBy('sort_order')->get(),
            'portfolio' => $markets->map(fn ($m) => [
                'name' => $m->name,
                'slug' => $m->slug,
                'region' => $m->region,
                'description' => $m->description,
                'office' => collect(\App\Models\SiteSetting::get('offices', []))
                    ->first(fn ($o) => strtoupper($o['country_code'] ?? '') === strtoupper($m->iso_code ?? '')),
                'products' => $m->products->map(fn ($p) => [
                    'name' => $p->name,
                    'image' => $p->image,
                    'category' => $p->category->name,
                    'url' => "/products/{$p->category->slug}/{$p->slug}",
                ])->values(),
            ]),
            'offices' => \App\Models\SiteSetting::get('offices', []),
            'content' => \App\Models\PageContent::for('markets.index'),
        ]);
    }
}
