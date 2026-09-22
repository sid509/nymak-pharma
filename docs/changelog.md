# Changelog

## 2026-09 — Initial build

Production Laravel 12 + Inertia React + SSR + SQLite rebuild of the Nymak
Pharma corporate website, engineered for SEO-first B2B lead generation.

### Foundation
- Laravel 12 scaffold, SQLite database, Tailwind 4, Manrope Variable font.
- Inertia.js v2 + React with server-side rendering (`inertia:start-ssr`).
- ADR-driven architecture: Blade-owned meta (works even if SSR is down),
  content-gated detail pages, data-backed catalog via seeders.

### Content model & data
- Migrations + models: product_categories, products, markets, posts, faqs,
  testimonials, certifications, enquiries, team_members.
- Real catalog seeded from nymakpharma.com + brochure: 317 products across
  5 categories, 11 markets, 12 FAQs, 4 posts, testimonials, certifications,
  team.
- 46 branded Liberia/Sierra Leone products with optimized WebP imagery get
  detail pages; generic rows render in grouped spec tables.
- Image pipeline: `scripts/convert-images.php` (cwebp), ~78MB → ~3.5MB.

### Public site
- Pages: Home, About, Manufacturing, Quality & Certifications, Products
  index/5 category pages/branded product detail, Global Presence + market
  pages (SL/Liberia/Nigeria), Blog index/post, FAQs, Contact, Privacy,
  Terms, branded 404.
- Contact form: server-side validation, honeypot + min-time + throttle spam
  gates, enquiry storage, queued email notification, admin inbox at /admin.
- Design: clinical-teal design system, mobile-first responsive, accessible
  (skip link, aria states, semantic markup, reduced-motion).

### SEO
- Meta/OG/Twitter/JSON-LD via Blade from a `Seo` builder per page.
- Organization+LocalBusiness+WebSite schema site-wide; Product/Article/
  FAQPage/BreadcrumbList per page type.
- Dynamic `sitemap.xml` (67 URLs), `robots.txt`, `llms.txt`.
- Unique titles/descriptions, canonicals, clean slug URLs, internal linking.
- GA4 + `nymakTrack` events for form/phone/email/WhatsApp; GSC env hook.

### Tests
- 25 PHP feature tests (pages, SEO, enquiries, admin) + 17 React tests
  (Vitest) — all green.

### Docs
- architecture, decisions, database, seo, testing, deployment, development,
  changelog, requirements-mapping.

## Phase 2 — Lead funnel + admin panel

### Lead funnel
- `?product={slug}` deep-link pre-selects a product in the enquiry form;
  product pages carry "Request a Quote".
- Brochure PDF download (hero, footer, contact sidebar) — tracked.
- Security headers middleware (strips `X-Powered-By`, adds nosniff/SAMEORIGIN/
  Referrer-Policy). LinkedIn URL corrected to the real profile.

### Admin panel
- `/admin` dashboard: unread enquiry badge, catalogue/content counts,
  actionable alerts, latest enquiries.
- Enquiries inbox: search, unread/read filter, expandable detail, read
  toggle, delete.
- CRUD: products (image upload→WebP, detail-page flag, SEO), categories
  (edit-only), markets (`has_page` gate), posts (draft/publish), FAQs,
  testimonials, certifications, team, admin users, own password.
- `Admin\CrudController` + generic React index/form pages shared by the four
  simple entities; dedicated pages where entities need more.
- Single-role auth (ADR-008); delete guards on referenced products/markets;
  self-delete blocked.

### Tests
- 43 PHP + 18 React tests — all green.
