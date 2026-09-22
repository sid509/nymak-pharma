# Nymak Pharma — Corporate Website

Production rebuild of the Nymak Pharma website. Nymak Pharma Private Limited
is a WHO-GMP certified pharmaceutical manufacturer and exporter (Star Export
House, est. 1998) headquartered in Mundra, Gujarat, India, supplying IV fluids,
finished formulations, medical devices, rapid diagnostic kits and vaccines to
partners in 24+ countries.

**Business goal:** Google ranking → technical SEO → organic traffic →
AI-search visibility → B2B lead generation. Every architectural decision is
in service of that funnel — content is server-rendered for crawlers, structured
for AI answer engines, and every page routes visitors to an enquiry.

**Stack:** Laravel 12 · PHP 8.3 · Inertia.js v2 · React 19 (SSR) · SQLite ·
Tailwind CSS 4 · Vite · Vitest

---

## How it works (30-second architecture)

```
Request ──> Laravel route ──> Controller ──> Eloquent (SQLite)
                                  │
                       Inertia::render('Page', props)
                                  │
            ┌─────────────────────┴─────────────────────┐
            ▼                                           ▼
   Blade shell (app.blade.php)                 Node SSR server
   emits title/meta/OG/schema                  renders React body
            └─────────────────────┬─────────────────────┘
                                  ▼
                        Full HTML to crawler/browser
                        React hydrates → SPA navigation
```

- **React pages** (`resources/js/Pages/`) are server-rendered via the Inertia
  SSR node process — crawlers and AI agents get complete HTML.
- **SEO metadata** is emitted by Blade from the `seo` prop, not React — title,
  canonical, OG and JSON-LD survive even if the SSR service is down (ADR-002).
- **Content lives in SQLite**, seeded from real company data — nothing is
  hardcoded into components.
- **Admin panel** (`/admin`) manages every content entity through the same
  models the public site reads — one domain, one source of truth.

## Prerequisites

| Tool | Version |
|---|---|
| PHP | 8.3+ (`ext-sqlite3`, `ext-mbstring`, `ext-imagick` or `gd` for uploads) |
| Composer | 2.x |
| Node.js | 20+ (22 LTS recommended) |
| npm | 10+ |

No MySQL, Redis, or external services needed — SQLite file + `database` queue
+ `log` mailer run entirely locally.

## Setup

```bash
# 1. Install dependencies
composer install && npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database (SQLite file + real seed data)
touch database/database.sqlite
php artisan migrate --seed        # seeds 317 products, 5 categories, markets, posts, FAQs…

# 4. Build frontend bundles (client + SSR)
npm run build

# 5. Run — two processes
php artisan serve                 # http://localhost:8000
php artisan inertia:start-ssr     # SSR on :13714 (second terminal)
```

Open **http://localhost:8000**.

### Development mode

```bash
npm run dev                       # Vite HMR on :5173 (replaces step 4's client bundle)
php artisan serve
php artisan inertia:start-ssr     # optional in dev — page body falls back to client render
```

### Admin panel

`/admin` → login. Credentials are seeded from env:

```dotenv
NYMAK_ADMIN_EMAIL=admin@nymakpharma.com
NYMAK_ADMIN_PASSWORD=your-strong-password   # set BEFORE first --seed
```

If the DB is already seeded, change the password via `/admin/profile` or:

```bash
php artisan tinker --execute="App\Models\User::first()->update(['password' => 'new-password'])"
```

See `docs/admin.md` for module capabilities.

### Verifying a fresh checkout

```bash
php artisan test                  # 43 feature tests (pages, SEO, admin CRUD, auth)
npm run test                      # 18 React component tests (Vitest)
```

Both must be green before touching anything else.

## What the site contains

**Public** — Home · About · Manufacturing · Quality & Certifications ·
Products (5 categories, 317 SKUs, 46 branded detail pages) · Global Presence
(11 markets, 3 with dedicated pages) · Blog · FAQs · Contact · Privacy · Terms ·
branded 404.

**Lead funnel** — validated enquiry form → DB → queued mail notification →
admin inbox; WhatsApp float + click-to-call + mailto; "Request a Quote" product
deep-links (`/contact?product=slug` pre-selects); brochure PDF download;
honeypot + min-time + throttle spam gates; GA4 event hooks.

**SEO infra** — SSR HTML · per-page title/description/canonical/OG/Twitter ·
JSON-LD (Organization, WebSite, Product, Article, FAQPage, BreadcrumbList) ·
`sitemap.xml` (67 URLs) · `robots.txt` · `llms.txt` · GSC verification hook ·
GA4 via `NYMAK_GA4_ID`.

## Configuration (.env)

| Variable | Purpose |
|---|---|
| `APP_URL` | Canonical base URL — drives canonicals, sitemap, schema URLs |
| `NYMAK_ENQUIRY_NOTIFY_TO` | Mailbox that receives enquiry notifications |
| `NYMAK_GA4_ID` | GA4 measurement ID — analytics off when empty |
| `NYMAK_GSC_VERIFICATION` | Search Console site-verification token |
| `NYMAK_ADMIN_EMAIL` / `NYMAK_ADMIN_PASSWORD` | Initial admin credentials (seed-time only) |
| `MAIL_*` | SMTP for real enquiry emails (`log` locally, `database` queue) |

Company facts (NAP, offices, socials, phone/WhatsApp) live in
`config/nymak.php` — edit there, never in templates.

## Repository layout

```
app/
├── Http/Controllers/       # Public page controllers (thin, SEO props)
│   └── Admin/              # Dashboard, Enquiries, CrudController + per-entity
├── Http/Requests/          # EnquiryRequest + Admin/* form requests
├── Models/                 # Product, ProductCategory, Market, Post, Faq,
│                           #   Testimonial, Certification, TeamMember, Enquiry, User
├── Support/                # Seo builder, ImageUpload (→WebP)
resources/
├── js/Pages/               # Public Inertia pages + Admin/*
├── js/Components/          # Site components + Components/Admin/*
├── js/Layouts/             # SiteLayout (public), AdminLayout
├── views/app.blade.php     # SSR shell — emits all <head> SEO meta
├── css/app.css             # Tailwind 4 tokens (brand/ink/gold palettes)
database/seeders/           # Real content seeders (products, markets, posts…)
public/
├── images/                 # Optimized WebP assets (products, logos, certs)
├── nymak-pharma-brochure.pdf
├── robots.txt · llms.txt
tests/Feature/              # 43 PHP tests   ·   tests/js/ — 18 React tests
scripts/convert-images.php  # repeatable PNG→WebP asset pipeline
docs/                       # full engineering documentation
```

## Conventions worth knowing

- **Meta flows through `seo` props** — controllers build it with
  `App\Support\Seo::make(title, description)`; Blade renders it. Never emit
  meta tags from React.
- **Slugs**: `Str::slug` after normalizing `/` → `-`. Category slugs are
  structural (not editable in admin). Public detail pages exist only when
  `has_detail_page`/`has_page` flags are set — don't generate thin pages.
- **Validation is server-side** — React forms display errors; Laravel Form
  Requests decide.
- **Images** go through `ImageUpload::store()` (admin) or
  `scripts/convert-images.php` (bulk assets) — always WebP in `public/images/`.
- **Tests**: feature tests seed the DB (`$seed = true`); SSR scoped state is
  flushed per request in `TestCase`.
- **Commits**: concise subjects focused on the why; no tool attributions.

## Troubleshooting

| Symptom | Fix |
|---|---|
| Page renders but body is empty | SSR server not running — `php artisan inertia:start-ssr` (meta/SEO still works — that's by design) |
| `419` on forms | Stale CSRF token — hard-refresh; check `SESSION_DRIVER=database` + migrated `sessions` table |
| `could not find driver` | `php -m \| grep sqlite` — enable `pdo_sqlite` + `sqlite3` |
| Admin login rejected after re-seed | Password comes from env at seed time — reset via tinker (above) |
| Uploaded image 404 | Check `public/images/products/` is writable by PHP |

## Documentation

| File | Contents |
|---|---|
| `docs/architecture.md` | system design, request lifecycle, SSR |
| `docs/decisions.md` | ADRs — stack, Blade meta, admin design, spam defense… |
| `docs/database.md` | schema, relationships, seeding, provenance |
| `docs/admin.md` | admin panel modules, access, architecture |
| `docs/seo.md` | keyword map, schema inventory, URL structure |
| `docs/testing.md` | suites, coverage map, release checklist |
| `docs/deployment.md` | production build, processes, DNS/email, launch steps |
| `docs/development.md` | env vars, conventions, adding content |
| `docs/requirements-mapping.md` | requirement → implementation → status |
| `docs/changelog.md` | what shipped, by phase |

## Deployment

Production is one PHP app + one Node SSR process behind a web server.
`docs/deployment.md` covers the build, supervisor/systemd units, env, and the
SPF/DKIM/DMARC + GSC + GA4 launch checklist.
