<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            ['/', '1.0', 'weekly'],
            ['/about', '0.8', 'monthly'],
            ['/manufacturing', '0.8', 'monthly'],
            ['/quality-certifications', '0.8', 'monthly'],
            ['/products', '0.9', 'weekly'],
            ['/global-presence', '0.8', 'monthly'],
            ['/blog', '0.7', 'weekly'],
            ['/faqs', '0.6', 'monthly'],
            ['/contact', '0.9', 'monthly'],
        ])->map(fn ($u) => ['loc' => url($u[0]), 'priority' => $u[1], 'freq' => $u[2], 'lastmod' => null]);

        $categories = ProductCategory::orderBy('sort_order')->get()
            ->map(fn ($c) => [
                'loc' => url("/products/{$c->slug}"),
                'priority' => '0.9',
                'freq' => 'weekly',
                'lastmod' => $c->updated_at,
            ]);

        $products = Product::where('has_detail_page', true)->with('category:id,slug')->get()
            ->map(fn ($p) => [
                'loc' => url("/products/{$p->category->slug}/{$p->slug}"),
                'priority' => '0.7',
                'freq' => 'monthly',
                'lastmod' => $p->updated_at,
            ]);

        $markets = Market::where('has_page', true)->get()
            ->map(fn ($m) => [
                'loc' => url("/global-presence/{$m->slug}"),
                'priority' => '0.7',
                'freq' => 'monthly',
                'lastmod' => $m->updated_at,
            ]);

        $posts = Post::published()->get()
            ->map(fn ($p) => [
                'loc' => url("/blog/{$p->slug}"),
                'priority' => '0.6',
                'freq' => 'monthly',
                'lastmod' => $p->updated_at,
            ]);

        $all = $urls->concat($categories)->concat($products)->concat($markets)->concat($posts);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            .$all->map(fn ($u) => '<url>'
                .'<loc>'.e($u['loc']).'</loc>'
                .($u['lastmod'] ? '<lastmod>'.$u['lastmod']->toDateString().'</lastmod>' : '')
                .'<changefreq>'.$u['freq'].'</changefreq>'
                .'<priority>'.$u['priority'].'</priority>'
                .'</url>')->join('')
            .'</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
