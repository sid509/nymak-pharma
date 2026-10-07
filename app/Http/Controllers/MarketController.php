<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;

use App\Models\Market;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(): Response
    {
        // Every market is a country on the interactive map. Selecting one
        // reveals *what we actually do* there — the rich content panel plus
        // the products supplied — instead of thin per-country pages.
        $offices = collect(SiteSetting::get('offices', []));

        $markets = Market::orderBy('sort_order')
            ->with(['products' => fn ($q) => $q->where('has_detail_page', true)
                ->with('category:id,slug,name,i18n')
                ->select('id', 'market_id', 'product_category_id', 'name', 'slug', 'image', 'i18n')])
            ->get()
            ->map(fn ($m) => [
                'name' => $m->name,
                'slug' => $m->slug,
                'iso_code' => $m->iso_code,
                'region' => $m->region,
                'description' => $m->description,
                'content' => $m->content,
                'latitude' => $m->latitude,
                'longitude' => $m->longitude,
                'featured' => $m->show_in_portfolio,
                'office' => $offices->first(fn ($o) => strtoupper($o['country_code'] ?? '') === strtoupper($m->iso_code ?? '')),
                'products' => $m->products->map(fn ($p) => [
                    'name' => $p->name,
                    'image' => $p->image,
                    'category' => $p->category->name,
                    'url' => "/product/{$p->category->slug}/{$p->slug}",
                ])->values(),
            ])->values();

        return Inertia::render('Markets/Index', [
            'seo' => Seo::make(
                'Global Presence — Pharmaceutical Exports to 24+ Countries',
                'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific.'
            )->override('markets.index')->breadcrumbs([
                ['Home', SetLocale::absolute('/')],
                ['Global Presence', SetLocale::absolute('/global-presence')],
            ])->toArray(),
            'markets' => $markets,
            'portfolio' => $markets->where('featured', true)->values(),
            'offices' => $offices->values(),
            'content' => PageContent::for('markets.index'),
        ]);
    }
}
