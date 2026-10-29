<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Certification;
use App\Models\ClientLogo;
use App\Models\Faq;
use App\Models\Market;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $content = PageContent::for('home');
        $faqs = $content['show_faqs'] ? Faq::orderBy('sort_order')->limit(3)->get() : collect();

        $seo = Seo::make(
            'Pharma Manufacturers in India: WHO-GMP',
            'Among pharma manufacturers in India, Nymak Pharma is a WHO-GMP certified exporter supplying IV fluids, medicines & medical devices to 24+ countries today.'
        )->override('home')->schema([
            '@type' => 'WebPage',
            'name' => 'Nymak Pharma: Pharmaceutical Manufacturer & Exporter',
            'url' => SetLocale::absolute('/'),
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
                ->with('category:id,name,slug,i18n')
                ->inRandomOrder()
                ->limit(6)
                ->get(['id', 'name', 'slug', 'image', 'description', 'product_category_id', 'i18n']) : [],
            'testimonials' => Testimonial::orderBy('sort_order')->get(['name', 'country', 'quote', 'i18n']),
            'certifications' => Certification::orderBy('sort_order')->limit(6)->get(['name', 'issuer', 'image']),
            'posts' => Post::published()->latest('published_at')->limit(3)
                ->get(['title', 'slug', 'category', 'excerpt', 'published_at', 'i18n']),
            'faqs' => $faqs,
            'stats' => SiteSetting::get('stats'),
            'clients' => ClientLogo::orderBy('sort_order')->get(['name', 'image']),
            'markets' => Market::orderBy('sort_order')->limit(9)->get(['name', 'slug', 'iso_code', 'region', 'i18n']),
            'content' => $content,
        ]);
    }
}
