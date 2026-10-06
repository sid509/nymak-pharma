# Testing

Two suites protect the behavior that matters.

## PHP — `php artisan test`

Pest-style PHPUnit feature tests in `tests/Feature/`, in-memory SQLite,
`RefreshDatabase` + `$seed = true` (real catalog content per test).

| Suite | Covers |
|---|---|
| `PagesTest` (14 tests) | every public page 200s with the right Inertia component; category landing + product-list pages; editable category content; interim/legacy 301s; trailing-slash normalization (middleware-level — the test client trims slashes); homepage product grid hidden unless toggled; detail-page contact CTA (no quote flow); wrong-category 404; no detail page for generic rows; draft posts 404; branded 404 page |
| `SeoTest` (6 tests) | title/meta/OG/Twitter/canonical present in HTML; content in initial HTML (the audit finding); unique category titles; valid sitemap XML >50 URLs; robots/llms.txt files; descriptions ≤170 chars |
| `EnquiryTest` (6 tests) | valid submission stores + notifies; required-field validation; honeypot fake-success (nothing stored); too-fast submissions treated as bots; malformed input rejected; product-linked enquiry |
| `AdminTest` (5 tests) | inbox auth-required; login + list; wrong creds rejected; mark-read/delete; guests can't modify |
| `GlobalPresenceMapTest` (7 tests) | map page exposes every market with ISO/pin data; coordinate-pinned regions; rich content reaches props as sanitised HTML; **WYSIWYG HTML sanitised on save** (script/handlers/`javascript:` stripped, safe links kept with `rel`); empty editor stores null; ISO + lat/lng validation; edit screen loads content |

Run: `php artisan test` → **25 tests, ~256 assertions.**

### The SsrState caveat (documented)

Inertia's `SsrState` is `scoped` — its `dispatched` flag persists across
kernel requests in one PHP process. Without flushing, a second `$this->get()`
in a test reuses the first request's SSR output. `tests/TestCase.php` calls
`forgetScopedInstances()` before each request — mirroring real php-fpm
behavior where each request is a fresh process. This is a test-harness
detail, not a production bug.

## React — `npm run test` (Vitest)

`vitest.config.js`, jsdom environment, setup mocks Inertia's `Link`/`usePage`/
`router`/`Head`/`useForm` so components render standalone.

| Suite | Covers |
|---|---|
| `Accordion.test` | renders questions as buttons with aria-expanded; opens/closes; keyboard-reachable; empty state |
| `SpecTable.test` | strength vs specimen columns; only detail-page rows link; empty table |
| `Markdown.test` | headings/paragraphs/lists/bold; **escapes raw HTML** (XSS); empty input |
| `Header.test` | primary nav + contact CTA; products dropdown aria state; mobile menu toggle; brand link |
| `WorldMap.test` | alpha-2 → atlas id lookup; ISO markets resolve to shapes + centroids, coordinate-only markets to pins; only markets are buttons with `aria-pressed`; click select/deselect; keyboard Enter/Space; hover/focus summary card |

Run: `npm run test` (or `vitest run`) → **17 tests.**

## Browser — real-user UAT (Playwright + real Chrome)

`tests/Browser/global-presence-map.mjs` drives Google Chrome through the
whole Global Presence workflow as an operator and a visitor would:

```sh
NYMAK_ADMIN_PASSWORD=… node tests/Browser/global-presence-map.mjs   # app on :8000
```

Admin logs in → creates a fresh market for the run → types headings, bold and
a bullet list in the WYSIWYG → saves → content round-trips into the editor.
Visitor → map renders clickable countries → hover card → click highlights the
country gold and shows the authored content → key-market products/office →
region list mirrors selection → pinned region → keyboard select → deep link
`#slug` → mobile scroll-into-view. Admin then deletes the market and it
disappears from the map. `HEADED=1` to watch it.

`tests/Browser/product-hierarchy.mjs` covers the catalogue restructure:

```sh
NYMAK_ADMIN_PASSWORD=… node tests/Browser/product-hierarchy.mjs   # app on :8000
```

`tests/Browser/locale.mjs` covers the multilingual public site:

```sh
NYMAK_ADMIN_PASSWORD=… node tests/Browser/locale.mjs   # app on :8000
```

Per-locale chrome (nav/footer/`<html lang>`), hreflang + `x-default`
alternates, nav links staying inside the locale, the flag switcher preserving
the current path, a French contact submission landing on `/fr/contact`, an
admin French product name round-trip (saved → live on `/fr` → cleared), and
the trilingual sitemap.

> Rate limits are real product behaviour: contact is throttled 5/min and
> admin login 6/min, so rapid back-to-back UAT runs trip the limiter
> (`no success flash`, login timeouts). `php artisan cache:clear` resets
> the counters between re-runs.

Admin → edits a category (WYSIWYG + intro; verified live and restored) →
toggles the home testimonials section off/on in Page content (verified live
each way). Visitor → home shows category cards and no product grid/quote
language → card opens the category landing page → "View all … products" opens
the full grouped list → a linked product opens the detail page, which offers
a contact CTA (`/contact?product=…` pre-selects it) and no quote flow → the
old `/products/…`, `/product/{slug}/` and legacy URLs all 301 to canonical
paths → mobile-viewport pass.

Known dev-only artifact: with the Vite HMR server running Laravel skips SSR,
so React logs a hydration mismatch on every page; the script ignores only that
message (SSR is on in production).

## What a green run means

- Every public URL renders and every SEO-critical tag is in HTML.
- The contact form can't silently lose a lead or let a bot in unlogged.
- The admin inbox is auth-gated.
- Admin-authored WYSIWYG HTML can't carry scripts or event handlers to the public site.
- Slugs are readable and bindings are scoped.

## Verification checklist before release

1. `php artisan migrate:fresh --seed && php artisan test` — all pass.
2. `npm run test` — all pass.
3. `npm run build` — client + SSR bundles build clean.
4. `php artisan serve` + `php artisan inertia:start-ssr` → curl `/` and
   confirm `<h1>` + `application/ld+json` + `<title>` in the HTML.
5. Lighthouse/PageSpeed on the deployed URL (target: mobile 90+).
