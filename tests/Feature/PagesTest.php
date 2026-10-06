<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    #[Test]
    public function all_public_pages_render(): void
    {
        $pages = [
            '/' => 'Home',
            '/about' => 'About',
            '/manufacturing' => 'Manufacturing',
            '/quality-certifications' => 'Quality',
            '/products' => 'Products/Index',
            '/global-presence' => 'Markets/Index',
            '/blog' => 'Blog/Index',
            '/faqs' => 'Faqs',
            '/contact' => 'Contact',
            '/privacy-policy' => 'Legal',
            '/terms' => 'Legal',
        ];

        foreach ($pages as $url => $component) {
            $this->get($url)
                ->assertOk()
                ->assertInertia(fn (Assert $page) => $page->component($component));
        }
    }

    #[Test]
    public function product_category_pages_render(): void
    {
        foreach (['iv-fluids', 'finished-formulations', 'medical-devices-and-disposables', 'rapid-diagnostic-kits', 'vaccines'] as $slug) {
            // Landing page — content-led, links through to the full list.
            $this->get("/product/{$slug}")
                ->assertOk()
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Products/Category')
                    ->has('groups')
                    ->where('category.slug', $slug)
                    ->where('category.catalogue_url', "/product/{$slug}/products")
                );

            // Full product list — the grouped tables live here now.
            $this->get("/product/{$slug}/products")
                ->assertOk()
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Products/Catalogue')
                    ->has('groups')
                );
        }
    }

    #[Test]
    public function category_landing_page_exposes_editable_content(): void
    {
        $this->get('/product/iv-fluids')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Products/Category')
                ->has('category.content')   // rich body seeded for every category
                ->has('category.intro')
                ->has('siblings')
            );
    }

    #[Test]
    public function legacy_and_trailing_slash_urls_redirect_to_canonical_paths(): void
    {
        // Old /products/{category} interim structure → new hierarchy.
        $this->get('/products/iv-fluids')->assertRedirect('/product/iv-fluids');
        $this->get('/products/iv-fluids/some-product')->assertRedirect('/product/iv-fluids/some-product');

        // Same for the unslashed spellings.
        $this->get('/about-us')->assertRedirect('/about');
        $this->get('/contact-us')->assertRedirect('/contact');
        $this->get('/iv-fluid')->assertRedirect('/product/iv-fluids');
    }

    #[Test]
    public function trailing_slashes_normalize_to_canonical_urls(): void
    {
        // MakesHttpRequests trims trailing slashes off test URIs, so the
        // middleware is exercised directly with real trailing-slash requests.
        $middleware = new \App\Http\Middleware\NormalizeUrls;
        $next = fn () => new \Symfony\Component\HttpFoundation\Response('OK');

        foreach ([
            '/product/iv-fluids/' => '/product/iv-fluids',
            '/product/iv-fluids/products/' => '/product/iv-fluids/products',
            '/team/' => '/team',
        ] as $from => $to) {
            $res = $middleware->handle(\Illuminate\Http\Request::create($from, 'GET'), $next);
            $this->assertSame(301, $res->getStatusCode());
            $this->assertSame($to, parse_url($res->headers->get('Location'), PHP_URL_PATH));
        }

        // Indexed legacy URLs resolve to their final path in ONE hop.
        foreach ([
            '/about-us/' => '/about',
            '/contact-us/' => '/contact',
            '/iv-fluid/' => '/product/iv-fluids',
        ] as $from => $to) {
            $res = $middleware->handle(\Illuminate\Http\Request::create($from, 'GET'), $next);
            $this->assertSame(301, $res->getStatusCode());
            $this->assertSame($to, parse_url($res->headers->get('Location'), PHP_URL_PATH));
        }

        // Query string is preserved; root and non-GET are untouched.
        $res = $middleware->handle(\Illuminate\Http\Request::create('/team/?x=1', 'GET'), $next);
        $this->assertSame('x=1', parse_url($res->headers->get('Location'), PHP_URL_QUERY));
        $this->assertSame('OK', $middleware->handle(\Illuminate\Http\Request::create('/', 'GET'), $next)->getContent());
        $this->assertSame('OK', $middleware->handle(\Illuminate\Http\Request::create('/contact', 'POST'), $next)->getContent());
    }

    #[Test]
    public function homepage_hides_product_grid_unless_admin_enables_it(): void
    {
        // Default: company page — categories are shown, no product cards.
        $this->get('/')->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->where('content.show_brands', false)
                ->where('featuredProducts', [])
                ->has('categories', 5)
            );

        // Admin flips the toggle — the grid's data appears.
        \App\Models\PageContent::updateOrCreate(
            ['page' => 'home', 'key' => 'show_brands'], ['value' => '1']);

        $this->get('/')->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('content.show_brands', true)
                ->has('featuredProducts.0')
            );
    }

    #[Test]
    public function global_presence_is_a_portfolio_not_per_country_pages(): void
    {
        // No thin/duplicate country pages — markets live as portfolio entries.
        $this->get('/global-presence')->assertOk()
            ->assertInertia(fn ($p) => $p->component('Markets/Index')->has('portfolio'));
        $this->get('/global-presence/sierra-leone')->assertNotFound();

        // Team index + bio-gated detail pages.
        $this->get('/team')->assertOk()
            ->assertInertia(fn ($p) => $p->component('Team/Index')->has('leadership'));
        $member = TeamMember::whereNotNull('bio')->firstOrFail();
        $this->get("/team/{$member->slug}")->assertOk()
            ->assertSee('"@type":"Person"', false);
        TeamMember::create(['name' => 'Mr. Test Person', 'slug' => 'test-person', 'role' => 'Analyst']);
        $this->get('/team/test-person')->assertNotFound();
    }

    #[Test]
    public function branded_product_detail_pages_render(): void
    {
        $this->get('/product/finished-formulations/alumak-20-120-tablets-liberia')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Products/Show')
                ->has('seo.schema')
            );

        // Slug must be readable — "20/120" → "20-120", not "20120".
        $this->assertDatabaseHas('products', ['slug' => 'alumak-20-120-tablets-liberia']);
    }

    #[Test]
    public function product_in_wrong_category_returns_404(): void
    {
        // Scoped bindings must prevent a branded FF product resolving under
        // the iv-fluids category URL.
        $this->get('/product/iv-fluids/alumak-20-120-tablets-liberia')->assertNotFound();
    }

    #[Test]
    public function generic_catalog_products_have_no_detail_page(): void
    {
        $product = \App\Models\Product::where('has_detail_page', false)->firstOrFail();
        $category = $product->category;

        $this->get("/product/{$category->slug}/{$product->slug}")->assertNotFound();
    }

    #[Test]
    public function product_detail_offers_contact_cta_not_quote(): void
    {
        $this->get('/product/finished-formulations/alumak-20-120-tablets-liberia')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Products/Show')
                ->where('content.cta_button', 'Contact us about this product')
                // No quote/ecommerce affordance anywhere in the page schema.
                ->missing('quote')
            );

        // The whole products.show schema contains no "quote" copy.
        $this->assertStringNotContainsStringIgnoringCase('quote',
            json_encode(\App\Models\PageContent::for('products.show')));
    }

    #[Test]
    public function related_products_link_under_their_own_category(): void
    {
        // Browser UAT caught related links built with the *current* page's
        // category slug — a cross-category match 404'd under scoped bindings.
        // Every emitted related URL must resolve on its own.
        $products = \App\Models\Product::where('has_detail_page', true)
            ->with('category:id,slug')->get();

        $checked = 0;
        foreach ($products as $product) {
            $response = $this->get("/product/{$product->category->slug}/{$product->slug}")->assertOk();
            foreach ($response->viewData('page')['props']['related'] ?? [] as $r) {
                $this->assertMatchesRegularExpression('#^/product/[a-z0-9-]+/[a-z0-9-]+$#', $r['url']);
                $this->get($r['url'])->assertOk();
                $checked++;
            }
        }

        $this->assertGreaterThan(0, $checked, 'no related links were emitted to verify');
    }

    #[Test]
    public function published_blog_posts_render_and_drafts_do_not(): void
    {
        $post = \App\Models\Post::published()->firstOrFail();
        $this->get("/blog/{$post->slug}")->assertOk();

        $draft = \App\Models\Post::create([
            'title' => 'Draft', 'slug' => 'draft-post', 'published_at' => null,
        ]);
        $this->get("/blog/{$draft->slug}")->assertNotFound();
    }

    #[Test]
    public function unknown_urls_return_branded_404(): void
    {
        $response = $this->get('/no-such-page-here');
        $response->assertNotFound();
        $response->assertInertia(fn (Assert $page) => $page->component('Error'));
    }
}
