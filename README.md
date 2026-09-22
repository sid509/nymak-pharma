# Nymak Pharma — Corporate Website

Production rebuild of the Nymak Pharma website: a WHO-GMP certified
pharmaceutical manufacturer & exporter (Star Export House) serving 24+
countries. Built SEO-first for B2B lead generation.

**Stack:** Laravel 12 · Inertia.js v2 · React (SSR) · SQLite · Tailwind 4 · Vite

## Quick start

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build
php artisan serve & php artisan inertia:start-ssr
```

Open http://localhost:8000. Admin inbox: `/admin`.

## What's here

- **Public site** — Home, About, Manufacturing, Quality & Certifications,
  Products (5 categories, 317 SKUs, branded detail pages), Global Presence
  (+ market pages), Blog, FAQs, Contact, legal pages.
- **Lead capture** — validated contact form → stored enquiry → queued email
  → admin inbox; honeypot + timing + throttle spam gates.
- **SEO-first** — SSR HTML, per-page meta/OG/Twitter/JSON-LD, dynamic
  sitemap, robots.txt, llms.txt, clean slugs, internal linking, GA4 hooks.
- **Tests** — 25 PHP feature tests + 17 React (Vitest) tests.
- **Docs** — full engineering documentation in `docs/`.

## Commands

```bash
php artisan test        # PHP feature tests
npm run test            # React component tests
npm run build           # client + SSR bundles
npm run dev             # Vite HMR
```

## Documentation

| File | Contents |
|---|---|
| `docs/architecture.md` | system design, layout, request lifecycle |
| `docs/decisions.md` | ADRs — why Inertia+SSR, Blade meta, gated pages… |
| `docs/database.md` | schema, relationships, seeding, provenance |
| `docs/seo.md` | keyword map, schema, URL structure, checklist |
| `docs/testing.md` | what each suite covers + release checklist |
| `docs/deployment.md` | build, processes, env, DNS/email, SEO launch steps |
| `docs/development.md` | setup, env vars, conventions, adding content |
| `docs/requirements-mapping.md` | requirement → implementation → status |
| `docs/changelog.md` | what shipped |
