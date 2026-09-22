# Requirements → Implementation Map

Source: `Requirements/requirements.md`. Status: ✅ done · 🔶 partial · ⏭ deferred (with reason)

| # | Requirement | Implementation | Status |
|---|---|---|---|
| 1 | Mobile PageSpeed 90+ | WebP assets (78MB→3.5MB), code-split pages, lazy images, hero `fetchpriority`, minimal JS, responsive Tailwind | 🔶 verify on deployed URL |
| 2 | GA4 + Search Console + conversion tracking | `NYMAK_GA4_ID`/`NYMAK_GSC_VERIFICATION` env, `window.nymakTrack` on form submit, tel/mailto/WhatsApp clicks | ✅ |
| 3 | Keyword mapping per page | `docs/seo.md` keyword table; `Seo::make` per controller | ✅ |
| 4 | Keyword density discipline | Natural copy, no stuffing; titles/descriptions bounded | ✅ |
| 5 | Unique meta titles | Per-page `seo.title`; `SeoTest` asserts uniqueness | ✅ |
| 6 | Meta descriptions 120–160 | `Str::limit(150)` in `Seo::make`; test asserts bound | ✅ |
| 7 | Clean URLs | Lowercase-hyphen slugs, scoped bindings, no IDs in public URLs | ✅ |
| 8 | 300+ words per important page | Category `description`, about/manufacturing copy, post bodies | ✅ |
| 9 | No thin/duplicate location pages | `markets.has_page` gate; non-page markets 404 | ✅ |
| 10 | Internal linking | Contextual links + breadcrumbs + sibling nav + related products | ✅ |
| 11 | Content in HTML / AI-readable | SSR + Blade meta; `llms.txt`; semantic HTML | ✅ |
| 12 | Heading hierarchy | One H1 via `PageHero`, logical H2/H3 | ✅ |
| 13 | Image SEO | WebP, descriptive filenames, alt text, dimensions, lazy loading | ✅ |
| 14 | HTTPS, canonical, robots, sitemap | Canonical per-page; `robots.txt`; dynamic `sitemap.xml` (67 URLs); HTTPS is deploy-time | ✅ |
| 15 | Structured data | Organization+LocalBusiness+WebSite site-wide; Product/Article/FAQPage/BreadcrumbList per page | ✅ |
| 16 | OG + X cards | Full tag set emitted per page | ✅ |
| 17 | NAP consistency | `config/nymak.php` single source → footer/contact/schema | ✅ |
| 18 | SPF/DKIM/DMARC | Infrastructure; checklist in `deployment.md` | 🔶 infra task |
| 19 | Hreflang | Deferred — single-language site | ⏭ |
| 20 | Email exposure review | Contact form is primary; published emails are role/public addresses | ✅ |
| 21 | AMP | Skipped per requirements (mobile perf prioritized) | ⏭ |
| 22 | Backlinks/PR | Out of code scope; noted for marketing | ⏭ |
| 23 | Social profiles | Config-driven `sameAs` + footer icons (suppress empty) | ✅ |
| 24 | Contact form → lead gen | `EnquiryRequest` validation + storage + queued mail + admin inbox; `?product=` deep-link pre-selects the product; brochure download + WhatsApp + tel/mailto all tracked | ✅ |
| 25 | Responsive across devices | Mobile-first Tailwind; hamburger nav; scrollable tables; tap targets | ✅ |
| 26 | Laravel backend | Laravel 12 | ✅ |
| 27 | React frontend | Inertia React + SSR | ✅ |
| 28 | SQLite | SQLite, portable schema | ✅ |
| 29 | Automated tests | 25 PHP + 17 React tests | ✅ |
| 30 | Documentation | This `docs/` set | ✅ |

## Ambiguities resolved (documented, not invented)

- **"24+ countries"** — brochure says 24+, one page said 22; standardized on 24+.
- **"25+ years"** — founded 1998; "25+" accurate now, kept consistent.
- **Which countries get pages** — only Sierra Leone, Liberia, Nigeria have
  real distinct content (offices/products/history); others list but don't page.
- **Admin scope** — requirements say "store + notify leads"; built minimal
  inbox, not a CMS.
- **Product detail coverage** — only branded products with images/copy get
  pages; generic rows live in tables (thin-content rule).
