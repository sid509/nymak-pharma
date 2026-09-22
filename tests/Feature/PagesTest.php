<?php

namespace Tests\Feature;

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
            $this->get("/products/{$slug}")
                ->assertOk()
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Products/Category')
                    ->has('groups')
                );
        }
    }

    #[Test]
    public function market_pages_only_render_for_content_rich_markets(): void
    {
        $this->get('/global-presence/sierra-leone')->assertOk();
        $this->get('/global-presence/liberia')->assertOk();
        // Ghana is a listed market without a dedicated page — must not render
        // a thin/duplicate page (requirement #9).
        $this->get('/global-presence/ghana')->assertNotFound();
    }

    #[Test]
    public function branded_product_detail_pages_render(): void
    {
        $this->get('/products/finished-formulations/alumak-20-120-tablets-liberia')
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
        $this->get('/products/iv-fluids/alumak-20-120-tablets-liberia')->assertNotFound();
    }

    #[Test]
    public function generic_catalog_products_have_no_detail_page(): void
    {
        $product = \App\Models\Product::where('has_detail_page', false)->firstOrFail();
        $category = $product->category;

        $this->get("/products/{$category->slug}/{$product->slug}")->assertNotFound();
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
