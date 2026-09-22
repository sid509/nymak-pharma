# Architecture Decision Records

## ADR-001 — Laravel + Inertia + React with SSR (not a plain SPA)

**Context.** Requirements mandate a React frontend *and* that "all important
text exists in crawlable HTML" — the SEO audit found the old React site
rendered only ~11% of content. A create-react-app/Vite SPA fails that
requirement outright.

**Alternatives considered.**

- *React SPA + Laravel API* — rejected: content invisible to crawlers/AI readers.
- *Next.js frontend + Laravel API* — rejected: two deployables, duplicated
  validation/routing surface, an API boundary that buys nothing here.
- *Laravel Blade only* — rejected: requirement mandates React.
- *Astro + Laravel API* — best content fit, but React components were required.

**Decision.** Laravel 12 + Inertia.js v2 + React + SSR (`inertia:start-ssr`).

**Trade-offs.** A Node SSR process must run alongside PHP (see deployment.md).
If it's unreachable, pages still return complete meta/schema via Blade and
hydrate client-side — degraded, not broken.

**Future.** If the marketing site later needs heavier interactivity
(e.g. client portal), Inertia supports it without re-architecting.

## ADR-002 — SEO meta rendered by Blade, not React `<Head>`

**Context.** Inertia's `<Head>` normally owns meta tags. But that ties meta
correctness to the SSR service being alive — if node is down, a page returns
no title, description or schema at all. For an SEO-first site that's fragile.

**Decision.** `app.blade.php` renders title/meta/OG/Twitter/JSON-LD directly
from `$page['props']['seo']`, built per-page by `App\Support\Seo`. React emits
no meta; a `router.on('success')` listener updates `document.title` after
client-side navigation (Inertia removes unmanaged `<title>` tags on nav).

**Trade-offs.** Meta doesn't live-update on SPA navigations (only title does) —
acceptable: meta freshness matters to crawlers (full page loads), not to
in-app navigations.

## ADR-003 — Data-backed content via SQLite + seeders

**Context.** The real catalog (~300 SKUs), markets, FAQs, team, testimonials
and certifications existed as unstructured brochure/site HTML.

**Decision.** Normalize into migrations + Eloquent models + seeders carrying
the real extracted data. `has_detail_page` / `has_page` flags gate which rows
generate URLs, implementing the "no thin pages" requirement in data rather
than convention.

**Trade-offs.** Content changes require a seeder edit + reseed rather than an
admin UI — acceptable for a marketing site; a CMS is a future enhancement.

## ADR-004 — Minimal session admin inbox (not a full CMS)

**Context.** Requirement: store enquiries and notify. Nothing requires
content management.

**Decision.** `/admin` = login + read/delete enquiries behind `auth`
middleware. No registration, no roles, no content editing.

**Reasoning.** Fewer moving parts, smaller attack surface. Admin credentials
come from env (`NYMAK_ADMIN_*`), created by the seeder. If a CMS is needed
later, it layers on cleanly.

**Superseded by ADR-008** — the admin surface grew into a full content panel;
the auth/session approach and env-seeded users were kept.

## ADR-005 — SQLite now, portable schema

**Decision.** SQLite per requirements. No SQLite-specific SQL; FKs, indexes
and constraints used normally, so `php artisan migrate` on MySQL/PostgreSQL
works unchanged. `DB_*` env vars are the only production change.

**Trade-off.** Concurrent writes are limited — irrelevant for a marketing
site's read-heavy profile.

## ADR-006 — Spam defense: honeypot + min-time + throttle (not CAPTCHA)

**Decision.** Contact form uses a hidden `website_url` honeypot, a
`form_started_at` minimum-elapsed check, and `throttle:5,1`. Bot submissions
return a fake success (nothing stored, no tip-off).

**Reasoning.** CAPTCHAs add friction and an external dependency; the site's
audience is B2B buyers on real browsers. The layered silent approach covers
the realistic spam profile. Re-evaluate if abuse appears.

## ADR-007 — WebP asset pipeline, one-time conversion

**Context.** Provided product PNGs totaled ~78 MB — unusable against the
PageSpeed-90 target.

**Decision.** `scripts/convert-images.php` (cwebp) converts the resource PNGs
to sized WebP in `public/images/` with slugified, descriptive filenames.
78 MB → ~3.5 MB. Images are committed as build artifacts (no runtime pipeline).

**Trade-offs.** New images need the same conversion step — documented in
development.md. Accepted: it keeps runtime simple and output deterministic.

## ADR-008 — Admin panel: same app, single role, shared CRUD

**Context.** The client plan requires the team to manage products, markets,
articles, FAQs and site content without developer help.

**Decision.** `/admin` is an Inertia/React interface inside the same app —
same models, same DB, same session auth (Laravel `auth` middleware, throttled
login). Single admin role: every `users` row is a full admin; no role matrix.
Simple entities (FAQs, testimonials, certifications, team) share
`Admin\CrudController` + two generic React pages driven by per-entity field
config. Products/posts/markets/categories/enquiries/users get dedicated
controllers and pages. Admin URLs bind by model route key (slug for
slugged models), public URL behavior unchanged.

**Alternatives considered.** Role/permission tables (spatie/permission):
rejected — the team is a handful of trusted admins; adding a matrix now is
speculative complexity. Filament/third-party admin: rejected — it would ship
a second design system and hide behavior from tests we control.

**Deferred deliberately.** Audit logging, per-role permissions, media library,
rich-text editor. Add when a real need appears — the schema and controllers
don't preclude them.

**Slug policy.** Admin edits accept a slug field; uniqueness is validated
server-side. Category slugs are not editable (they're structural URLs).
Changing a public slug does not create a redirect — acceptable now since the
site pre-launch; if it ships, add a `redirects` table before allowing edits.

## Assumptions documented (not decisions)

- **Country count**: brochure says "24+ countries" while some pages said 22 —
  we standardize on **"24+"** (the brochure's stronger, more recent claim).
- **Years**: founded 1998 → "25+ years" (accurate through 2024+).
- **Emails**: `info@nymakpharma.com` is the canonical public address; regional
  office emails are published per-office as they are already public.
- **Social profiles**: LinkedIn/Instagram/X URLs present in config; only
  non-empty socials render icons or `sameAs` schema — set real URLs or leave
  empty to suppress.
