<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\ClientLogo;
use App\Models\Faq;
use App\Models\Market;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Testimonial;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $content = PageContent::for('home');
        $faqs = $content['show_faqs'] ? Faq::orderBy('sort_order')->limit(6)->get() : collect();

        $seo = Seo::make(
            'Pharmaceutical Manufacturer & Exporter in India',
            'Nymak Pharma — WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices, rapid test kits and vaccines to 24+ countries.'
        )->override('home')->schema([
            '@type' => 'WebPage',
            'name' => 'Nymak Pharma — Pharmaceutical Manufacturer & Exporter',
            'url' => \App\Http\Middleware\SetLocale::absolute('/'),
            'isPartOf' => ['@id' => url('/#website')],
            'about' => ['@id' => url('/#organization')],
        ]);

        if ($faqs->isNotEmpty()) {
            $seo->schema([
                '@type' => 'FAQPage',
                'mainEntity' => $faqs->map(fn ($f) => [
                    '@type' => 'Question',
                    'name' => $f->question,
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
                ]),
            ]);
        }

        return Inertia::render('Home', [
            'seo' => $seo->toArray(),
            'categories' => ProductCategory::orderBy('sort_order')
                ->withCount('products')
                ->get(['id', 'name', 'slug', 'icon', 'intro', 'i18n'])
                ->map(function ($cat) {
                    $cat->samples = $cat->products()
                        ->where('has_detail_page', true)
                        ->whereNotNull('image')->where('image', '!=', '')
                        ->orderBy('sort_order')->limit(3)
                        ->get(['name', 'slug', 'image', 'strength', 'i18n']);
                    return $cat;
                }),
            // Only queried when the admin has switched the brands grid on.
            'featuredProducts' => $content['show_brands'] ? Product::where('has_detail_page', true)
                ->whereNotNull('image')
                ->with('category:id,name,slug')
                ->inRandomOrder()
                ->limit(8)
                ->get(['id', 'name', 'slug', 'image', 'description', 'product_category_id', 'i18n']) : [],
            'testimonials' => Testimonial::orderBy('sort_order')->get(['name', 'country', 'quote', 'i18n']),
            'certifications' => Certification::orderBy('sort_order')->get(['name', 'issuer', 'image']),
            'posts' => Post::published()->latest('published_at')->limit(3)
                ->get(['title', 'slug', 'category', 'excerpt', 'published_at', 'i18n']),
            'faqs' => $faqs,
            'stats' => \App\Models\SiteSetting::get('stats'),
            'clients' => ClientLogo::orderBy('sort_order')->get(['name', 'image']),
            'markets' => Market::orderBy('sort_order')->limit(9)->get(['name', 'slug', 'iso_code', 'region', 'i18n']),
            'content' => $content,
        ]);
    }
}
