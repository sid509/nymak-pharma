# Testing

Two suites protect the behavior that matters.

## PHP — `php artisan test`

Pest-style PHPUnit feature tests in `tests/Feature/`, in-memory SQLite,
`RefreshDatabase` + `$seed = true` (real catalog content per test).

| Suite | Covers |
|---|---|
| `PagesTest` (10 tests) | every public page 200s with the right Inertia component; category pages; content-gated market pages; branded product detail; wrong-category 404; no detail page for generic rows; draft posts 404; branded 404 page |
| `SeoTest` (6 tests) | title/meta/OG/Twitter/canonical present in HTML; content in initial HTML (the audit finding); unique category titles; valid sitemap XML >50 URLs; robots/llms.txt files; descriptions ≤170 chars |
| `EnquiryTest` (6 tests) | valid submission stores + notifies; required-field validation; honeypot fake-success (nothing stored); too-fast submissions treated as bots; malformed input rejected; product-linked enquiry |
| `AdminTest` (5 tests) | inbox auth-required; login + list; wrong creds rejected; mark-read/delete; guests can't modify |

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

Run: `npm run test` (or `vitest run`) → **17 tests.**

## What a green run means

- Every public URL renders and every SEO-critical tag is in HTML.
- The contact form can't silently lose a lead or let a bot in unlogged.
- The admin inbox is auth-gated.
- Slugs are readable and bindings are scoped.

## Verification checklist before release

1. `php artisan migrate:fresh --seed && php artisan test` — all pass.
2. `npm run test` — all pass.
3. `npm run build` — client + SSR bundles build clean.
4. `php artisan serve` + `php artisan inertia:start-ssr` → curl `/` and
   confirm `<h1>` + `application/ld+json` + `<title>` in the HTML.
5. Lighthouse/PageSpeed on the deployed URL (target: mobile 90+).
