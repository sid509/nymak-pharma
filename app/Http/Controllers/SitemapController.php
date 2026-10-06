<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TeamMember;
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
            ['/team', '0.6', 'monthly'],
            ['/inside-nymak', '0.5', 'monthly'],
            ['/blog', '0.7', 'weekly'],
            ['/faqs', '0.6', 'monthly'],
            ['/contact', '0.9', 'monthly'],
        ])->map(fn ($u) => ['path' => $u[0], 'priority' => $u[1], 'freq' => $u[2], 'lastmod' => null]);

        // Category landing page + its full product list — both indexable.
        $categories = ProductCategory::orderBy('sort_order')->get()
            ->flatMap(fn ($c) => [
                ['path' => "/product/{$c->slug}", 'priority' => '0.9', 'freq' => 'weekly', 'lastmod' => $c->updated_at],
                ['path' => "/product/{$c->slug}/products", 'priority' => '0.8', 'freq' => 'weekly', 'lastmod' => $c->updated_at],
            ]);

        $products = Product::where('has_detail_page', true)->with('category:id,slug')->get()
            ->map(fn ($p) => [
                'path' => "/product/{$p->category->slug}/{$p->slug}",
                'priority' => '0.7',
                'freq' => 'monthly',
                'lastmod' => $p->updated_at,
            ]);

        // Team member detail pages — one URL each, gated on bio presence.
        $members = TeamMember::whereNotNull('bio')->get()
            ->map(fn ($m) => [
                'path' => "/team/{$m->slug}",
                'priority' => '0.5',
                'freq' => 'yearly',
                'lastmod' => $m->updated_at,
            ]);

        $posts = Post::published()->get()
            ->map(fn ($p) => [
                'path' => "/blog/{$p->slug}",
                'priority' => '0.6',
                'freq' => 'monthly',
                'lastmod' => $p->updated_at,
            ]);

        $all = $urls->concat($categories)->concat($products)->concat($members)->concat($posts);

        // Every path exists in three locales; each <url> carries hreflang
        // alternates so crawlers understand the language cluster.
        $alternates = fn (string $path) => collect(SetLocale::LOCALES)
            ->map(fn ($l) => '<xhtml:link rel="alternate" hreflang="'.$l.'" href="'.e(SetLocale::absolute($path, $l)).'"/>')
            ->join('')
            .'<xhtml:link rel="alternate" hreflang="x-default" href="'.e(SetLocale::absolute($path, 'en')).'"/>';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'
            .$all->flatMap(fn ($u) => collect(SetLocale::LOCALES)->map(fn ($l) => '<url>'
                .'<loc>'.e(SetLocale::absolute($u['path'], $l)).'</loc>'
                .$alternates($u['path'])
                .($u['lastmod'] ? '<lastmod>'.$u['lastmod']->toDateString().'</lastmod>' : '')
                .'<changefreq>'.$u['freq'].'</changefreq>'
                .'<priority>'.$u['priority'].'</priority>'
                .'</url>'))->join('')
            .'</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
