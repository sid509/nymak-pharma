# Database

SQLite (`database/database.sqlite`). All migrations are portable — FKs,
unique constraints, indexes — no SQLite-specific SQL, so `migrate` works on
MySQL/PostgreSQL unchanged.

## Schema

```text
product_categories ─┬─< products >─┬─ markets
                    │              └─ (products.market_id nullable)
products ───────────┴─< enquiries (enquiries.product_id nullable)

posts · faqs · testimonials · certifications · team_members  (standalone)
users (admin auth) · jobs · cache (Laravel scaffold)
```

## Table notes

**product_categories** — `slug` unique, `icon` (lucide name), `intro`,
`description` (plain-text fallback), `content` (sanitised WYSIWYG HTML —
the landing-page body), `image`, `meta_title`, `meta_description`,
`sort_order`. Index on `sort_order`.

**products** — the catalog (~317 rows). Fields:
`product_category_id` FK cascade, `market_id` FK nullOnDelete, `name`,
`slug` unique, `therapeutic_group`, `strength`, `pack_size`, `specimen`
(used by diagnostic kits), `description`, `image`, `meta_*`,
`has_detail_page` (gates URL generation), `sort_order`.
Indexes: `(product_category_id, sort_order)`, `therapeutic_group`,
`has_detail_page`, `slug` unique.

**markets** — `slug` unique, `iso_code` (ISO 3166-1 alpha-2, drives the
world-map highlight), `region`, `description` (short plain summary — hover
card), `content` (sanitised WYSIWYG HTML — map detail panel), `latitude` /
`longitude` (optional pin for multi-country regions or centroid override),
`show_in_portfolio` ("key market"), `sort_order`.

**posts** — `slug` unique, `category`, `excerpt`, `body` (markdown),
`cover_image`, `meta_*`, `published_at` nullable. Index on `published_at`.
`Post::published()` scope.

**faqs** — `category`, `question`, `answer`, `sort_order`.

**testimonials** — `name`, `country`, `quote`, `sort_order`.

**certifications** — `name`, `issuer`, `description`, `image`, `sort_order`.

**enquiries** — contact fields + `product_id` FK, `subject`, `message`,
`ip_address`, `read_at` nullable. Indexes on `read_at`, `created_at`.
`Enquiry::unread()` scope.

**team_members** — `name`, `role`, `is_leadership`, `sort_order`.

## Query patterns

- All list rendering uses `orderBy('sort_order')` — content order is editorial.
- Relationship loads are eager (`with`, `withCount`, constrained `load`) —
  verified no N+1 on category/market pages.
- Public lookups bind by `slug` (`getRouteKeyName()`), not IDs.
- Scoped bindings on `/product/{category}/{product}` — a product URL 404s
  under the wrong category. The catalogue hierarchy is
  `/products` → `/product/{category}` (landing) → `/product/{category}/products`
  (full list) → product detail. `NormalizeUrls` middleware 301s trailing
  slashes, and `/products/{category}` interim URLs 301 onward.
- Pagination: posts (9/page), admin enquiries (20/page) — `paginate()`.
- Random ordering (`inRandomOrder`) used only for featured-product carousels
  where order doesn't matter — small N (≤8).

## Seeding

`php artisan db:seed` runs the real catalog. `DatabaseSeeder` also
creates the admin user from `NYMAK_ADMIN_EMAIL`/`NYMAK_ADMIN_PASSWORD` env.

Seeding is idempotent per fresh migrate; `migrate:fresh --seed` is the
local reset path. The admin user uses `updateOrCreate` so reseeding
doesn't error.

## Data provenance

All seeded content derives from the provided resources:
- `database/seeders/ProductSeeder.php` — product tables scraped from
  nymakpharma.com category pages (IV fluids, formulations, devices, kits,
  vaccines) + the branded Liberia/Sierra Leone portfolio.
- `MarketSeeder` — only markets with verified presence are seeded.
- `FaqSeeder`, `PostSeeder`, `TestimonialSeeder`, `CertificationSeeder`,
  `TeamMemberSeeder` — from the brochure PDF and current site copy.

## Backup / migration note

SQLite file lives at `database/database.sqlite` — a single file copy is a
full backup. For production, point `DB_*` at MySQL/PostgreSQL and re-run
`migrate --seed`.
