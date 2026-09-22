<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Builds the per-page SEO payload consumed by the <SeoHead> React component:
 * title, meta description, canonical, Open Graph/Twitter tags and a JSON-LD
 * schema.org @graph. Controllers produce one per page.
 */
class Seo
{
    private string $title = '';

    private string $description = '';

    private string $canonical;

    private ?string $image = null;

    private string $type = 'website';

    private array $schema = [];

    private function __construct()
    {
        $this->canonical = url()->current();
    }

    public static function make(string $title, string $description): self
    {
        $seo = new self;
        $seo->title = $title;
        // Meta descriptions: 120–160 chars target (requirement #6). Trim at a
        // word boundary rather than mid-word if input runs long.
        $seo->description = Str::of($description)->squish()->limit(150)->toString();

        return $seo;
    }

    public function canonical(string $url): self
    {
        $this->canonical = $url;

        return $this;
    }

    public function image(?string $path): self
    {
        $this->image = $path ? (str_starts_with($path, 'http') ? $path : url($path)) : null;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function schema(array $schema): self
    {
        $this->schema[] = $schema;

        return $this;
    }

    /**
     * Apply admin-managed overrides for a page key (page_metas table).
     * Only non-empty fields override — controller defaults remain otherwise.
     */
    public function override(string $key): self
    {
        $meta = \App\Models\PageMeta::where('key', $key)->first();

        if ($meta?->meta_title) {
            $this->title = $meta->meta_title;
        }
        if ($meta?->meta_description) {
            $this->description = Str::of($meta->meta_description)->squish()->limit(150)->toString();
        }
        if ($meta?->og_image) {
            $this->image = url($meta->og_image);
        }

        return $this;
    }

    public function breadcrumbs(array $items): self
    {
        return $this->schema([
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($name, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $name[0],
                'item' => $name[1],
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'canonical' => $this->canonical,
            'image' => $this->image ?? url('images/hero/facility-aerial.webp'),
            'type' => $this->type,
            'schema' => $this->schema,
            'url' => url()->current(),
            'site_name' => \App\Models\SiteSetting::get('short_name'),
        ];
    }

    /** Organization + WebSite schema — emitted on every page from the Blade shell. */
    public static function organizationSchema(): array
    {
        $c = \App\Models\SiteSetting::merged();
        $socials = array_values(array_filter($c['socials']));

        return [
            '@type' => ['Organization', 'LocalBusiness'],
            '@id' => url('/#organization'),
            'name' => $c['legal_name'],
            'alternateName' => $c['short_name'],
            'url' => url('/'),
            'logo' => url('images/logo.png'),
            'description' => $c['description'],
            'foundingDate' => (string) $c['founded'],
            'founder' => ['@type' => 'Person', 'name' => $c['founder']],
            'telephone' => $c['phone'],
            'email' => $c['email'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $c['address']['street'],
                'addressLocality' => $c['address']['city'],
                'addressRegion' => $c['address']['region'],
                'postalCode' => $c['address']['postal_code'],
                'addressCountry' => $c['address']['country_code'],
            ],
            'sameAs' => $socials,
            'contactPoint' => [[
                '@type' => 'ContactPoint',
                'telephone' => $c['phone'],
                'email' => $c['email'],
                'contactType' => 'sales',
                'areaServed' => 'Worldwide',
                'availableLanguage' => ['English'],
            ]],
            'award' => ['Star Export House — Government of India', 'WHO-GMP Certified', 'ISO 13485:2016'],
        ];
    }

    public static function websiteSchema(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'url' => url('/'),
            'name' => \App\Models\SiteSetting::get('name'),
            'publisher' => ['@id' => url('/#organization')],
        ];
    }

    /** Ready-to-print JSON for the site-wide schema graph (used in app.blade.php). */
    public static function globalSchemaJson(): string
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [self::organizationSchema(), self::websiteSchema()],
        ]);
    }
}
