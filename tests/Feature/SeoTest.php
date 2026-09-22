<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Verifies the SSR'd HTML carries the SEO essentials — the whole point of the
 * architecture is that crawlers see real content without executing JS.
 */
class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    #[Test]
    public function homepage_html_contains_meta_and_schema(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<title[^>]*>[^<]*Nymak Pharma[^<]*<\/title>/', $html);
        $this->assertStringContainsString('name="description"', $html);
        $this->assertStringContainsString('rel="canonical"', $html);
        $this->assertStringContainsString('property="og:title"', $html);
        $this->assertStringContainsString('property="og:image"', $html);
        $this->assertStringContainsString('name="twitter:card"', $html);
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('Organization', $html);
        $this->assertStringContainsString('FAQPage', $html);
    }

    #[Test]
    public function content_is_present_in_initial_html(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        // The audit's core complaint: rendered content must be in HTML.
        $this->assertStringContainsString('Efficacy-Driven Lifecare', $html);
        $this->assertMatchesRegularExpression('/<h1[^>]*>.+<\/h1>/s', $html);
    }

    #[Test]
    public function category_pages_have_unique_titles_and_descriptions(): void
    {
        $titles = [];
        foreach (['iv-fluids', 'finished-formulations', 'rapid-diagnostic-kits'] as $slug) {
            $html = $this->get("/products/{$slug}")->assertOk()->getContent();
            preg_match('/<title[^>]*>([^<]+)<\/title>/', $html, $m);
            $titles[] = $m[1];
            $this->assertStringContainsString('name="description"', $html);
        }
        $this->assertSame($titles, array_unique($titles), 'Category titles must be unique (requirement #5).');
    }

    #[Test]
    public function sitemap_is_valid_xml_with_expected_urls(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');

        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
        $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urls = array_map('strval', $xml->xpath('//s:loc'));
        $this->assertGreaterThan(50, count($urls));
    }

    #[Test]
    public function robots_txt_and_llms_txt_exist_and_are_correct(): void
    {
        // Static files are served by the web server, not the app kernel —
        // so we assert on the shipped files directly.
        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Sitemap:', $robots);
        $this->assertStringContainsString('Disallow: /admin', $robots);

        // llms.txt is generated from site settings + catalogue (dynamic route)
        $llms = $this->get('/llms.txt')->assertOk()->getContent();
        $this->assertStringContainsString('Nymak Pharma', $llms);
        $this->assertStringContainsString('/products', $llms);
    }

    #[Test]
    public function meta_descriptions_stay_within_limit(): void
    {
        foreach (['/', '/about', '/contact', '/products/iv-fluids'] as $url) {
            $html = $this->get($url)->assertOk()->getContent();
            preg_match('/name="description" content="([^"]+)"/', $html, $m);
            $this->assertNotEmpty($m[1], "Missing meta description on {$url}");
            $this->assertLessThanOrEqual(170, strlen(html_entity_decode($m[1])), "Description too long on {$url}");
        }
    }
}
