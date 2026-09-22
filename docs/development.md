# Development

## Requirements

- PHP 8.3+ with `pdo_sqlite`, `sqlite3`, `gd`/`imagick`, `intl`, `mbstring`
- Composer 2.x, Node 22+, npm
- `cwebp` (for image conversion; only needed when adding images)

## First run

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed      # real catalog data
npm run build                   # client + SSR bundles

# two processes:
php artisan serve               # app on :8000
php artisan inertia:start-ssr   # SSR on :13714
```

Open http://localhost:8000. Login: `/admin` (env `NYMAK_ADMIN_*`).

## Dev loop

- `npm run dev` — Vite dev server + HMR (SSR keeps using the built bundle)
- `npm run build` — production assets (`vite build && vite build --ssr`)
- `php artisan test` — PHP feature suite
- `npm run test` — Vitest React suite

## Env vars that matter

```env
NYMAK_MAILTO=info@nymakpharma.com   # enquiry notification recipient
NYMAK_GA4_ID=G-XXXXXXX              # enables GA4 when set
NYMAK_GSC_VERIFICATION=...          # Google Search Console meta tag
NYMAK_ADMIN_EMAIL=admin@nymakpharma.com
NYMAK_ADMIN_PASSWORD=...            # used by seeder for admin login
INERTIA_SSR_ENABLED=true            # keep true; Blade meta covers downtime
```

`config/nymak.php` is the single source of truth for NAP (name/address/phone),
offices, socials, stats, enquiry spam settings and analytics IDs.

## Adding content

- **New catalog row** → `database/seeders/ProductSeeder.php`, reseed.
- **New market page** → `MarketSeeder.php` with a real `description` and
  `has_page: true` (only add when the market has unique, substantial content).
- **New FAQ/post** → `FaqSeeder.php` / `PostSeeder.php`.
- **New images** → drop PNG into `Resources`, run
  `php scripts/convert-images.php`, reference the produced `.webp` path.

## Conventions

- One controller per page concern; controllers stay thin — SEO payload via
  `App\Support\Seo`, queries eager-loaded.
- Shared props (`site`, `nav`, `flash`, `auth`) come from
  `HandleInertiaRequests` — don't re-fetch them per controller.
- React pages live under `resources/js/Pages/{Area}/`, shared UI under
  `Components/`. Tailwind 4 tokens in `resources/css/app.css` (`@theme`).
- Don't add `<Head>` meta in React — Blade owns meta (ADR-002). Pages just
  pass a `seo` prop.
- Icons: lucide-react for UI; `Components/SocialIcons.jsx` for brands.
