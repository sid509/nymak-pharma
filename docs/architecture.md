# Architecture

## Overview

Nymak Pharma is a Laravel 12 application serving a server-rendered React
frontend via Inertia.js v2. SQLite is the current datastore; the schema avoids
SQLite-specific features so a later move to MySQL/PostgreSQL is a config change.

```
Browser / Crawler
      │
      ▼
Laravel 12 (routes → controllers → Eloquent models → SQLite)
      │
      ├── Blade shell (app.blade.php): meta, OG/Twitter, JSON-LD, GA4, assets
      │
      └── Inertia SSR (node bootstrap/ssr/ssr.js): React pages → HTML
```

The key architectural property: **all meaningful content is present in the
first HTML response.** Meta tags and JSON-LD are rendered by Blade directly
from the `seo` page prop — they exist even if the SSR service is down.
SSR additionally renders the page body (React → HTML) so crawlers and AI
readers see full content without executing JavaScript.

## Why Inertia + SSR instead of a plain React SPA

The brief requires React *and* "content must be in HTML, not dependent on
JavaScript" (the audit's core finding: ~11% rendered content on the old site).
A client-only SPA cannot satisfy both. Inertia SSR gives us:

- React component model and routing (per requirements)
- Full HTML on first response (SEO/AIO requirement)
- One deployable, no separate API layer to design, version and secure
- Laravel conventions stay authoritative (validation, auth, CSRF, forms)

See `decisions.md` ADR-001 for alternatives and trade-offs.

## Directory layout

```
app/
├── Http/
│   ├── Controllers/          # thin, one per page concern
│   │   └── Admin/            # login + enquiry inbox (session auth)
│   ├── Middleware/HandleInertiaRequests.php  # shared props: site, nav, flash, auth
│   └── Requests/EnquiryRequest.php           # contact validation + spam gates
├── Models/                   # Eloquent models, slug route-binding
├── Notifications/EnquiryReceived.php         # queued mail on new enquiry
└── Support/Seo.php           # SEO payload builder + site-wide schema.org

resources/js/
├── Layouts/SiteLayout.jsx    # header/footer/WhatsApp float/flash toast
├── Components/               # Header, Footer, Ui, Cards, Accordion,
│                             # SpecTable, EnquiryForm, Markdown, SocialIcons
└── Pages/                    # one file per route; props come from controllers

database/seeders/             # real catalog data from nymakpharma.com + brochure
docs/                         # this documentation set
```

## Request lifecycle

1. Route → controller queries models (eager-loaded), builds a `Seo` payload.
2. `Inertia::render('Page', props)` → `Response::toResponse()`.
3. Blade renders: `<title>`/meta/OG/Twitter/JSON-LD from `$page['props']['seo']`,
   site-wide Organization/WebSite schema, GA4 snippet (env-gated), Vite assets,
   and `@inertiaHead` which receives the SSR-rendered head + body markup.
4. Client hydrates; subsequent navigations are XHR (Inertia protocol) and
   `document.title` is re-asserted from the new page's `seo` prop on `success`.

## Data model

| Table | Purpose | Notable fields |
|---|---|---|
| product_categories | 5 segments | slug, icon, intro, description, meta_* |
| products | 317 catalog rows | category_id, market_id, therapeutic_group, strength, pack_size, specimen, image, has_detail_page, meta_* |
| markets | export markets | slug, region, has_page (only content-rich markets get URLs) |
| posts | insights/articles | slug, category, body (markdown), published_at |
| faqs | grouped Q&A | category, question, answer, sort_order |
| testimonials | client quotes | name, country, quote |
| certifications | credentials | name, issuer, description, image |
| enquiries | lead inbox | contact fields, product_id, ip_address, read_at |
| team_members | people | name, role, is_leadership |

Detail-page granularity: only products with `has_detail_page` (the ~46 branded
marketed products that have images and real copy) get URLs. The ~270 generic
catalog rows render inside category tables — giving each a page would produce
thin/duplicate content, which the requirements explicitly warn against.
Same logic for `markets.has_page`.

## Admin area

`/admin` is a minimal session-authenticated enquiry inbox (login, list,
expand, mark-read, delete). It's deliberately tiny — not a CMS. Login is
rate-limited (6/min) and all admin responses carry `noindex`.

## Failure modes

| Failure | Behavior |
|---|---|
| SSR service down | Page still returns meta/schema (Blade) + app div; body hydrates client-side |
| Empty tables | Pages render empty states, no "No data found" artifacts |
| Mail/queue down | Enquiry still stored; notification queues for retry |
| Bot submission | Honeypot + min-time + throttle → fake success, nothing stored |
| Missing asset | Cards render icon placeholder; layout doesn't shift |
