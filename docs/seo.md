# SEO Implementation

Everything here maps to `Requirements/requirements.md`. See
`requirements-mapping.md` for the checklist form.

## The one principle

**Content, meta and schema must exist in the initial HTML** — the audit's
core finding. This is enforced architecturally:

- Meta/title/OG/Twitter/JSON-LD → rendered by `app.blade.php` from the
  `seo` page prop (works even with SSR down).
- Page body → SSR'd by Inertia/node to full HTML.
- `llms.txt`, `sitemap.xml`, `robots.txt` → served at root.

## Per-page SEO payload

Controllers build it via `App\Support\Seo`:

```php
Seo::make($title, $description)          // title, ≤150-char description
    ->image($path)                       // og:image (absolute)
    ->type('article'|'product')          // og:type
    ->schema([...])                      // JSON-LD node(s)
    ->breadcrumbs([[name,url], ...])     // BreadcrumbList node
    ->toArray()
```

Rendered in `resources/views/app.blade.php`:
- `<title>{seo.title} | Nymak Pharma</title>`
- `meta[name=description]`, `link[rel=canonical]`, `meta[name=robots]`
- `og:type/title/description/url/site_name/image`
- `twitter:card/title/description/image`
- one `ld+json` per `schema[]` node, plus the site-wide graph
  (Organization + WebSite) emitted on every page.

## Schema types in use

| Type | Where |
|---|---|
| Organization + LocalBusiness | site-wide (`Seo::organizationSchema`) |
| WebSite | site-wide |
| BreadcrumbList | every page with breadcrumbs |
| FAQPage | home (top FAQs), /faqs, quality page |
| Product | branded product detail pages |
| Article | blog posts |
| WebPage | home |

Organization carries name, logo, founding info, NAP-consistent address,
contactPoint, `sameAs` socials and `award` (WHO-GMP / Star Export House /
ISO 13485).

## URL structure

Clean, hyphenated, keyword-forward (requirement #7):

```
/                                        home
/about                                   company
/manufacturing                           facility
/quality-certifications                  quality
/products                                index — category overview
/product/{category}                      category landing (editorial content)
/product/{category}/products             full grouped product list
/product/{category}/{product}            detail — detail-enabled products only
/global-presence                         markets index (interactive map)
/blog, /blog/{post}
/faqs, /contact
/privacy-policy, /terms
/sitemap.xml, /robots.txt, /llms.txt
```

`/product/{category}` preserves the live site's established category URLs.
Interim `/products/{category}` URLs 301 to `/product/{category}`;
`NormalizeUrls` middleware also strips trailing slashes (`/product/iv-fluids/`
→ `/product/iv-fluids`) and one-hops known legacy paths (`/about-us/` → `/about`,
`/iv-fluid/` → `/product/iv-fluids`).

Scoped route model binding on `/product/{category}/{product}` enforces that
a product URL only resolves under its own category — no orphan/duplicate URLs.

## Page inventory & keyword mapping

| Page | Focus keyword | Intent |
|---|---|---|
| `/` | pharmaceutical manufacturer & exporter india | brand + category |
| `/product/iv-fluids` | iv fluids manufacturer india | category |
| `/product/finished-formulations` | pharmaceutical finished formulations | category |
| `/product/medical-devices-and-disposables` | medical devices supplier india | category |
| `/product/rapid-diagnostic-kits` | rapid diagnostic kits manufacturer | category |
| `/product/vaccines` | vaccines & antisera exporter | category |
| `/product/{category}/products` | {category} product list | catalogue |
| `/manufacturing` | pharmaceutical manufacturing facility gujarat | capability |
| `/quality-certifications` | who-gmp certified pharmaceutical | trust |
| `/global-presence` | pharmaceutical exports 24 countries | reach |
| `/contact` | pharmaceutical export enquiry | conversion |
| `/blog/*` | informational | authority |

Each carries a unique title (`SeoTest` asserts non-duplicate titles), a
≤160-char description, one H1, a logical H2/H3 tree, breadcrumbs, and CTAs.

## Requirements met (condensed)

- **Content in HTML** (#11) — SSR + Blade meta; `content_is_present_in_initial_html` test.
- **Titles** (#5) — unique, keyword-forward, ≤60-ish chars, `| Nymak Pharma` suffix.
- **Descriptions** (#6) — `Str::limit(150)` enforced; test asserts ≤170.
- **Meta/OG/Twitter** (#16) — all emitted per-page.
- **URLs** (#7) — lowercase-hyphen slugs, unique via DB constraint.
- **Images** (#13) — WebP, descriptive slugs, alt text, width/height attrs, lazy below fold, `fetchpriority="high"` on hero.
- **Headings** (#12) — one H1 per page (`PageHero`), semantic H2/H3.
- **Internal links** (#10) — contextual links between about/products/quality/markets/contact throughout.
- **Schema** (#15) — above table.
- **Sitemap** (#14) — `/sitemap.xml`, 67 URLs, dynamic from DB.
- **robots** — `public/robots.txt`, disallows `/admin`, points to sitemap.
- **Canonical** — per-page absolute canonical.
- **HTTPS** — deployment concern (see deployment.md).
- **Analytics** (#2) — GA4 via `NYMAK_GA4_ID` env; `window.nymakTrack` events wired to form submit + tel/mailto/WhatsApp clicks; GSC verification via `NYMAK_GSC_VERIFICATION`.
- **NAP consistency** (#17) — single source in `config/nymak.php`, shared to header/footer/contact/schema.
- **Email exposure** (#20) — contact form is the primary CTA; published emails are role-based addresses already public.
- **Hreflang** (#19) — deferred: single-language site; add when translations exist.
- **AMP** (#21) — intentionally skipped per requirements.
- **Mobile** (#1) — responsive, table scroll regions, `prefers-reduced-motion`, min-height tap targets; PageSpeed to be measured post-deploy.

## Deliberately not done

- Thin/duplicate country pages (requirement #9) — `has_page` flag.
- Per-page for all 300 catalog rows — thin content; detail pages only for
  branded products with real copy.
- Keyword stuffing — keyword use is contextual, no density gaming.
