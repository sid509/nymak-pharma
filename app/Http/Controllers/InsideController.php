<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\PageContent;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class InsideController extends Controller
{
    public function __invoke(): Response
    {
        // Portfolio markets with the products supplied in each — the market
        // explorer's data source.
        $portfolio = Market::where('show_in_portfolio', true)
            ->orderBy('sort_order')
            ->with(['products' => fn ($q) => $q->where('has_detail_page', true)
                ->with('category:id,name,slug')
                ->select('id', 'market_id', 'product_category_id', 'name', 'slug', 'image')])
            ->get()
            ->map(fn ($m) => [
                'name' => $m->name,
                'region' => $m->region,
                'description' => $m->description,
                'products' => $m->products->map(fn ($p) => [
                    'name' => $p->name,
                    'image' => $p->image,
                    'category' => $p->category->name,
                    'url' => "/products/{$p->category->slug}/{$p->slug}",
                ])->values(),
            ]);

        return Inertia::render('Inside', [
            'seo' => Seo::make(
                'Inside Nymak — An Interactive Story | Nymak Pharma',
                'An interactive walk through Nymak Pharma — from a 1998 startup in Mundra to an exporter trusted across 24+ countries.'
            )->override('inside')->breadcrumbs([
                ['Home', url('/')],
                ['Inside Nymak', url('/inside-nymak')],
            ])->toArray(),
            'content' => PageContent::for('inside'),
            'stats' => SiteSetting::get('stats', []),
            'timeline' => PageContent::for('about')['timeline'],
            'portfolio' => $portfolio,
            'categories' => ProductCategory::orderBy('sort_order')
                ->withCount('products')
                ->get(['name', 'slug', 'intro']),
            'leadership' => TeamMember::where('is_leadership', true)->orderBy('sort_order')
                ->get(['name', 'slug', 'role', 'photo', 'bio'])
                ->map(fn ($m) => [
                    'name' => $m->name, 'slug' => $m->slug, 'role' => $m->role,
                    'photo' => $m->photo, 'initials' => $m->initials(),
                    'has_page' => filled($m->bio),
                ]),
        ]);
    }
}
