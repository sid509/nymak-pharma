<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Multilingual public site — English canonical unprefixed, /fr and /es
 * prefixed, model translations with English fallback, locale-aware SEO.
 */
class LocaleTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    #[Test]
    public function english_routes_are_unprefixed_and_locales_prefixed(): void
    {
        foreach (['/about', '/contact', '/products', '/global-presence', '/faqs', '/blog', '/team', '/privacy-policy'] as $path) {
            $this->get($path)->assertOk();
            $this->get("/fr{$path}")->assertOk();
            $this->get("/es{$path}")->assertOk();
        }
        $this->get('/fr')->assertOk();
        $this->get('/es')->assertOk();
    }

    #[Test]
    public function unsupported_locale_prefix_404s(): void
    {
        $this->get('/de/about')->assertNotFound();
        $this->get('/frx/about')->assertNotFound();
    }

    #[Test]
    public function html_lang_and_hreflang_follow_the_locale(): void
    {
        $html = $this->get('/fr/about')->assertOk()->getContent();
        $this->assertStringContainsString('lang="fr"', $html);
        $this->assertStringContainsString('hreflang="en"', $html);
        $this->assertStringContainsString('hreflang="fr"', $html);
        $this->assertStringContainsString('hreflang="es"', $html);
        $this->assertStringContainsString('hreflang="x-default"', $html);
    }

    #[Test]
    public function page_props_carry_locale_dictionary_and_alternates(): void
    {
        $this->get('/fr/products')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->where('locale', 'fr')
            ->has('i18n.Contact Us')
            ->where('locales.en', '/products')
            ->where('locales.fr', '/fr/products')
            ->where('locales.es', '/es/products')
        );

        $this->get('/products')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->where('locale', 'en')
            ->where('i18n', [])
            ->where('locales.en', '/products')
        );
    }

    #[Test]
    public function translated_model_content_renders_and_english_falls_back(): void
    {
        $product = Product::where('has_detail_page', true)->firstOrFail();
        $product->setTranslations('fr', ['name' => 'Nom français']);
        $product->setTranslations('es', ['name' => 'Nombre español']);
        $product->save();

        // FR renders the French name in props; ES where set; untranslated fields keep EN.
        $this->get("/fr/product/{$product->category->slug}/{$product->slug}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->where('product.name', 'Nom français'));

        $this->get("/es/product/{$product->category->slug}/{$product->slug}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->where('product.name', 'Nombre español'));

        // EN canonical still serves the base value.
        $this->get("/product/{$product->category->slug}/{$product->slug}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->where('product.name', $product->getRawOriginal('name')));

        // A locale with no translation falls back to English.
        $product->setTranslations('es', ['name' => null]);
        $product->save();
        $this->get("/es/product/{$product->category->slug}/{$product->slug}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->where('product.name', $product->getRawOriginal('name')));
    }

    #[Test]
    public function nav_links_and_breadcrumbs_stay_in_locale(): void
    {
        $this->get('/fr/products')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->where('nav.categories.0.href', fn ($href) => str_starts_with($href, '/fr/'))
        );
    }

    #[Test]
    public function contact_post_under_locale_redirects_back_in_locale(): void
    {
        $response = $this->post('/fr/contact', [
            'name' => 'Jean Dupont',
            'company' => 'Pharma Distrib',
            'email' => 'jean@example.com',
            'phone' => '+33 1 00 00 00 00',
            'country' => 'France',
            'subject' => 'Enquiry',
            'message' => 'Bonjour, nous souhaitons distribuer vos produits.',
            'privacy' => true,
            'form_started_at' => now()->subMinutes(2)->timestamp,
        ]);

        $response->assertRedirect('/fr/contact');
        $this->assertDatabaseHas('enquiries', ['email' => 'jean@example.com']);
    }

    #[Test]
    public function legacy_redirects_preserve_the_locale_prefix(): void
    {
        $this->get('/fr/about-us')->assertRedirect('/fr/about');
        $this->get('/fr/contact-us')->assertRedirect('/fr/contact');
        $this->get('/es/about-us')->assertRedirect('/es/about');
        $this->get('/about-us')->assertRedirect('/about');
    }

    #[Test]
    public function sitemap_lists_every_path_in_all_locales_with_alternates(): void
    {
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();
        $this->assertStringContainsString('<loc>'.url('/about').'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.url('/fr/about').'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.url('/es/about').'</loc>', $xml);
        $this->assertStringContainsString('hreflang="x-default"', $xml);
        $this->assertStringContainsString('hreflang="fr"', $xml);
    }

    #[Test]
    public function route_generation_uses_url_defaults_for_the_current_locale(): void
    {
        // The redirect Location header proves route('contact') picked up locale=fr.
        $response = $this->post('/es/contact', [
            'name' => 'Maria García',
            'company' => 'Distribuidora SA',
            'email' => 'maria@example.com',
            'phone' => '+34 600 000 000',
            'country' => 'Spain',
            'subject' => 'Enquiry',
            'message' => 'Hola, nos gustaría distribuir sus productos.',
            'privacy' => true,
            'form_started_at' => now()->subMinutes(2)->timestamp,
        ]);
        $response->assertRedirect('/es/contact');
    }
}
