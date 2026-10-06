# Changelog

## Multilingual public site — English, Français, Español

The public site now runs three locales. English stays the
canonical unprefixed variant (`/about`); French and Spanish
live under `/fr/…` and `/es/…`. The admin panel remains
English-only.

- **Routing** — every public route registers twice: a
  `{locale?}`-prefixed group (constrained to `fr|es`) first so
  named routes carry the locale param, then bare English
  routes (Laravel's optional-first-segment matching won't
  reach `/about` through the prefixed pattern). `SetLocale`
  middleware reads the prefix, sets `app()->setLocale`, sets
  `URL::defaults(['locale' => …])` so `route()` generates the
  matching prefix, and `forgetParameter('locale')` keeps
  implicit model bindings positional. Legacy redirects
  (`/about-us` → `/about`) preserve the prefix.
- **Content translations** — translatable models carry an
  `i18n` JSON column (`{fr: {name: …}, es: {name: …}}`).
  `HasTranslations` resolves attribute reads + `toArray()`
  through the current locale with English fallback, so
  controllers, SEO and JSON-LD localize automatically; admin
  (no locale set) always edits the English base. Rich-text
  fields are sanitised on write. Applies to Product,
  ProductCategory, Market, Post, Faq, TeamMember, Testimonial
  and PageContent slots (text/textarea/richtext).
- **UI chrome** — `lang/fr.json` + `lang/es.json` translate
  via English source keys; shared `i18n`/`locale`/`locales`
  props drive a `useT()` hook, `LocaleLink`/`ButtonLink`
  prefix internal hrefs, and a header `LanguageSwitcher`
  (plain anchors to the shared `locales` alternates — a full
  reload keeps SSR + document lang in sync).
- **SEO** — `<html lang>`, self-referencing canonicals,
  `hreflang` alternates + `x-default`, `og:locale` +
  alternates, locale-aware breadcrumbs/JSON-LD URLs, and a
  sitemap emitting every path ×3 locales with alternates.
- **Admin** — `TranslationFields` component adds FR/ES inputs
  (WYSIWYG for richtext) to product, category, market, post
  and generic CRUD forms; PageContent slots get inline FR/ES
  fields; FormRequests validate `i18n.*.*`; controllers merge
  via `setTranslations()`.
- **Tests** — `tests/Feature/LocaleTest` (10 cases: prefixed
  routing, 404 on bad locales, lang/hreflang, prop shape,
  model translation + EN fallback, locale-aware redirects,
  contact POST, sitemap); `tests/Browser/locale.mjs` (11-step
  real-Chrome journey: chrome per locale, switcher, French
  contact submission, admin FR-name round-trip, sitemap).
  Three real bugs found and fixed en route — see UAT-07/08/09.


## Branded error pages — all common HTTP statuses

- `bootstrap/app.php` `respond()` now routes **401, 402, 403,
  404, 405, 408, 419, 422, 429, 500, 503** to the Inertia
  `Error` page (was 404/500/503 only) with per-status SEO
  titles, all `noindex`. JSON/API callers still get JSON.
- **Root-cause fix:** error responses render without route
  middleware having run (unmatched 404s, CSRF 419s, throttle
  429s) → shared props (`site`, `nav`, `flash`, `auth`,
  `admin`) were absent → `SiteLayout` crashed on
  `site.phone_href` and SSR returned nothing. `respond()` now
  resolves `HandleInertiaRequests::share()` explicitly,
  defensively per key so a missing session/DB can't break the
  error page itself.
- `Header`/`Footer` destructure `site = {}` as a second
  safety net.
- `Pages/Error.jsx` redesigned: gradient status number,
  eyebrow label, per-status copy, contextual CTAs (401→sign
  in, 404→catalogue), "go back to previous page" link.
- Self-contained Blade fallbacks `resources/views/errors/
  500.blade.php` + `503.blade.php` (shared `_shell` partial,
  inline styles, no DB deps) — Laravel uses these when the
  Inertia render itself can't run (e.g. DB down).
- In dev, real 500s still show the framework's debug page
  (`APP_DEBUG` + not testing) — Ignition stays usable.
- New `tests/Feature/ErrorPagesTest.php` — 7 cases: branded
  SSR markup for 404/403/419/429/500, Blade fallback for
  non-HTTP exceptions, JSON pass-through.

## Admin branding — Nymak logo + Hitee credit

- `AdminLayout` sidebar header now renders the shared `Logo`
  component (`light` variant) — same markup drives the mobile
  drawer.
- Every admin page gets a footer credit: "Crafted by [Hitee
  logo]" linking to https://hitee.ai with `target="_blank"
  rel="noopener noreferrer"`; top border, full-opacity logo.
- `Admin/Login` gains the same "Crafted by hitee.ai" credit
  under the sign-in card.
- Mobile top bar shows the Nymak logo beside the hamburger
  (`Logo` gained a `size="sm"` compact variant for bars).
- `Logo light` (dark surfaces: admin sidebar, site footer)
  reworked — the favicon N monogram + white wordmark text
  instead of the horizontal logo on a white chip, which read
  as a pasted overlay.
- Hitee wordmark assets sized for web at
  `public/images/brand/hitee-logo.png` (dark, for light
  surfaces) and `hitee-logo-white.png` (spare, dark surfaces).

## Admin dashboard — informative, charted, SSR-safe

- Rebuilt `Admin/Dashboard` around insight panels: 4 KPI cards
  (unread enquiries with accent state, 30-day enquiries with
  period-over-period delta pill, products with detail-page
  count, markets served with category count), secondary stat
  chips (published/draft articles, team, detail pages missing
  images), then six panels — 30-day enquiry trend area chart
  with hover crosshair + tooltip, enquiries by country ranked
  bars, product-mix donut with legend, branded-range-by-market
  bars with flags, content-health progress (images / detail
  pages / published articles), latest enquiries with unread
  dots, most-enquired products.
- Charts are hand-rolled SVG (`TrendChart`, `DonutChart`) —
  deterministic markup under SSR, no library, brand-styled
  (`#22a52e`/`#0086d4` palette), `role="img"` + aria labels.
  Recharts was tried and removed: its prebundled copy resolves
  a second React instance → `useContext` crash → blank page.
- `DashboardController` gained the datasets (trend filled to a
  continuous 30-day series, country counts, category/market
  product counts, top products, recent enquiries) and fixed a
  SQLite-incompatible `HAVING products_count` → `has()`.
- Enquiry timestamps formatted server-side (`when` attr) so
  SSR/client markup is identical across timezones.

## Dev-SSR hydration — root cause found and fixed

- **Bug:** every page logged a hydration mismatch, and under
  one configuration every page went dead — clicks did nothing.
- **Why:** with Vite hot, `laravel/inertia` sends SSR requests
  to `{vite}/__inertia_ssr`, which the vite dev server never
  serves → SSR silently skipped → empty `#app` → `hydrateRoot`
  mismatch. Making SSR answer anyway was worse: the built SSR
  bundle is *production* React while Vite serves *development*
  React — hydrating prod markup with dev React suspends
  hydration permanently (events captured, never dispatched).
- **Fix:** `INERTIA_SSR_ENABLED=false` in `.env` (dev only —
  production deploys set it true where both bundles share the
  same production React), `app.jsx` now mounts with
  `createRoot` when `#app` has no `data-server-rendered` and
  `hydrateRoot` when it does — zero console errors either way.
- Also restarted the months-stale SSR daemon + vite dev
  servers (they held pre-change bundles), and guarded
  `SiteLayout`'s `site` prop (`site?.tawk_property`) — a real
  SSR crash on error pages without shared props.
- Removed stray `package.json`/`package-lock.json` files the
  earlier Recharts attempts left in the repo's parent dir.

## Rebrand — theme recolored to the official logo

- `brand-*` scale is now the logo's **green** (primary —
  buttons, nav pills, eyebrows, FABs, hovers) and `gold-*`
  holds the logo's **azure blue** (accent — supply arcs,
  selected map states, badges). One CSS-vars change recolors
  every component.
- `.text-gradient` is now `blue → azure → green` (logo order)
  and is the **default for all `SectionHeading` titles** — every
  section subtitle renders the brand gradient.
- Chat FAB is Tawk.to only (no WhatsApp fallback — goes to
  /contact until `tawk_property` is set in Settings).
- Map copy: "Every gold arc…" → "Every arc…" (arcs are now
  brand blue, not gold).
- `--shadow-card-hover` and map focus/selected glows shifted to
  the new palette.

## Brand refresh — real logo, bigger type, new FAB layout

- **Official logo** — `Nymak Pharma rgb.png` (from the client
  brand pack, same asset as nymakpharma.com) copied to
  `public/images/brand/nymak-logo.png` and set via the
  `logo` site setting (Admin → Settings can still override).
  The `Logo` component wraps it in a white chip on dark
  surfaces so the dark wordmark stays readable in the footer.
- **Favicon** — the blue/green N symbol cropped from the
  transparent logo → `public/favicon.png` (replaces favicon.svg).
- **Type scale bump** — `t-*` tokens stepped up: hero 56px,
  page titles 46px, H2 38px, H3 27px, H4 21px, lead 19px,
  body 17px, captions 14px, eyebrows 13px, nav/buttons 16px —
  all inside the client's spec ranges; `.prose-nymak` body
  copy at 17px.
- **FAB layout** — brochure + WhatsApp moved to bottom-LEFT;
  new teal "Live chat" FAB bottom-RIGHT: opens the Tawk.to
  widget when `tawk_property` is set in Settings
  (lazy-loads `embed.tawk.to` on first click), otherwise
  falls back to WhatsApp.
- **Content** — quality_body refreshed with the live site's
  certification copy ("Each accolade reflects our deep-rooted
  commitment…"); hero subtitle already carries their tagline.

## Gradient display text

- New `.text-gradient` utility — `brand-800 → brand-500 →
  gold-500` (deep teal through vivid teal to export gold,
  matching the globe's supply-route gold), `background-clip:
  text`.
- `SectionHeading` gains a `titleClass` prop; the home About
  title ("A pharmaceutical manufacturer India has exported
  through since 1998") uses it.

## Global presence — dark hero

- `PageHero` gains an opt-in `tone="dark"` variant — deep
  `brand-950 → ink-950` gradient, ring motif + teal radial glow
  (same dark-panel language as About/CTA), and a `children` slot
  for extra content. Also gains `align="center"` — centered
  breadcrumbs, eyebrow, title, lead and children.
- `Eyebrow` and `Breadcrumbs` gain `dark` (and `center`) props
  adapting their colors/layout for dark canvases.
- The Global Presence hero uses it, plus a live-facts strip
  (countries / regions / key markets / offices — all computed
  from real props, not duplicated copy) filling the dead space
  under the lead.
- "Don't see your market?" CTA band — centered, ring motif +
  top glow that scales on card hover, handshake badge, two
  channels: primary "Start the conversation" → /contact and a
  WhatsApp outline pill (site.whatsapp). New fields
  `cta_label`, `cta_alt_label`.

## Global presence — empty states get context + CTAs

- No-selection panel: quick-pick chips for up to four markets
  (featured first, else first listed) jump straight into the
  detail view, plus a "Your market not listed? Ask us →" contact
  CTA — the placeholder panel now guides instead of sitting
  empty.
- Empty-country state: replaces the bare "registrations in
  progress" line with a brand-tinted card carrying an editable
  title + body (`{country}` interpolates the market name) and a
  "Talk to our export team →" outline CTA to /contact.
- New admin-editable fields: `map_empty_cta`,
  `map_market_empty_title`, `map_market_empty_body`,
  `map_market_cta` (Admin → Page content → Global presence).
- Facility CTA: "See our facility" is now an outlined pill with
  a Factory icon matching the pill button system.

## Centered section headers (Cipla-style)

- `SectionHeading` default `align` flipped to `center` — every
  consumer (portfolio, testimonials, credentials, capabilities,
  dosage, offices, journey, map, brands…) now centers.
- Split sections restructured so the eyebrow+title span the full
  width centered above the two-column content (About preview,
  Global presence, Markets footprint, About/Manufacturing/Quality
  overviews) — the Cipla pattern, rather than centering a title
  inside a half-width column.
- Quality strip, certifications band and footprint tiles widened
  to full-width grids with centered CTAs; FAQ accordion centers
  at `max-w-3xl`; journal header CTA moved below the grid.
- Inside page: story/explorer headers and closing CTA centered;
  Team sections use `Eyebrow center` + `text-center` h2s.

## Certifications → auto-scrolling carousel

- The home Quality & Compliance strip is now a **carousel of
  bigger tiles** (w-64/72, `h-28` cert art, name + issuer, card
  shadow + hover lift) reusing the `.marquee` infrastructure —
  seamless duplicated loop, auto-scrolls at 26s, pauses on
  hover/focus, `overflow-x: auto` fallback under
  `prefers-reduced-motion`.
- All five certs show (was `slice(0,4)` — the IEC tile was
  silently dropped).

## Hero — back to full-bleed image, blended

- Facility photo is once again the **full hero background** —
  this time blended instead of slabbed: a directional scrim
  (`ink-950/85 → 50 → 15`, left→right) keeps the copy readable
  while the photo still reads through on the right, and a bottom
  `white → transparent` fade dissolves the hero's edge into the
  page so the floating stats card sits on a clean seam.
- Scroll parallax preserved (±20px drift inside a 12% overscan);
  badge becomes a frosted-glass pill (`white/10` + backdrop-blur),
  secondary CTA switches to `outlineLight`, location chip folded
  into the About fact panel (was duplicated here).
- Hero min-height `30–38rem` gives the image room; text column
  capped at `max-w-2xl`.

## Brochure → floating action button

- Brochure download is now a **global FAB** in `SiteLayout`:
  teal `brand-600` circle stacked above the WhatsApp bubble
  (bottom-right), expanding on hover to reveal the "Brochure"
  label — animated via `max-width`/`padding`/`opacity`, tracked
  as `brochure_download` with `placement: 'fab'`. Rendered only
  when the admin brochure upload exists (Settings → Product
  brochure controls it).
- Hero's inline brochure link removed (redundant vs the FAB);
  `show_hero_brochure`/`hero_brochure_label` admin fields retired
  from `PageContent` defs. Footer + Contact context links remain.
- FAB is **highlighted**: a soft `brand-500` ring pulses outward
  every 2.8s and the download icon gently bobs — both disabled
  under `prefers-reduced-motion`. Hover still expands to the
  "Brochure" label and deepens to `brand-700`.

## Button system → pills

- `ButtonLink` variants restyled: `rounded-lg px-5 py-3` →
  `rounded-full px-6 py-2.5` — pill shape matches the nav pills
  and hero badge, killing the "default AI template" boxy look.
- Outline hover gains a soft `brand-50/60` fill for clearer
  feedback.
- EnquiryForm submit and mobile-nav CTA rounded to pills; the
  whole CTA family (header, hero, section CTAs, forms) now shares
  one pill language with the `btn-cta` sheen + arrow-travel
  micro-interaction.

## Header consolidation — Company dropdown + xl breakpoint

- Nine flat links → **6 primary items + a "Company" dropdown**
  (Our Team / Inside Nymak / Blog) + Contact pill. Dropdown is
  tap-toggleable, hover/focus-open, and gets the active pill when
  on a company page.
- Desktop nav breakpoint `lg` → `xl` — the 1024–1280px range now
  gets the hamburger instead of a cramped bar.
- Mobile menu gains a "Company" eyebrow section with the three
  links under the same bordered-sublist style as Products.
- `dropOpen` state generalised to `openMenu` ('products'|'company')
  with per-dropdown refs for outside-click.

## Header redesign — pill nav

- Nav links now use **pill states** — hover `ink-50`, active
  `brand-50` + `brand-800` — replacing the underline-sweep
  animation (`.nav-link::after` removed; CSS cleaned incl. the
  reduced-motion rule). Same language as the mobile menu and
  mega-menu tiles, applied to the split Products trigger too.
- Topbar recoloured `ink-950` → `brand-950` (deep teal) with a
  `brand-300` "WHO-GMP Certified" highlight and hairline
  separators — brand-tinted chrome instead of generic black.
- "Contact Us" CTA is now a `rounded-full` pill.

## Header width + footer shell

- Header chrome (utility bar, main nav, mobile nav) and footer now
  use a wider `max-w-[90rem]` shell with `lg:px-10` — the header
  spans the viewport like modern corporate sites while page content
  stays at `max-w-7xl`.
- Mega-menu category names wrap to two lines instead of truncating
  ("Medical Devices & Disp…" → full name).

## KPI card interactivity + product packshots in the explorer

- The floating stats card is now interactive: each KPI carries a
  pharma-relevant icon tile (HeartPulse lifecare, Globe2 exports,
  Container shipping, Pill products) that inverts to brand fill on
  hover; the cell lifts with a soft `brand-50` tint and the figure
  steps to `brand-800`. `Stat` gains an `icon` prop — dark Markets
  stats unchanged.
- Segment explorer preview now shows up to 3 **real product
  packshots** per category (name-tooltip links to each detail page)
  via a new `samples` payload in `HomeController` — actual Nymak
  products on the landing page without turning it into a catalogue.
- Stat label shortened to "Containers per FY" (DB + `PageContent`
  default) — the old value wrapped mid-year leaving "24" orphaned.

## Products nav → mega-menu

- The Products dropdown is now a **two-column mega-menu** ("Product
  portfolio" eyebrow, category tiles with icon + live product count,
  "All product categories" footer link) instead of a plain text list.
- `nav.categories` shared prop now carries `icon` + `products_count`
  (`withCount` in `HandleInertiaRequests`).
- Mobile menu's category sublist gains the same teal icons + counts.
- Dropdown still works pre-hydration (CSS hover/focus) and on tap.
- Header compacted: nav bar `py-3→py-2` (61px) and the topbar collapse
  now truly reaches 0 — its `py-1.5` padding counted toward the grid
  item's min-content, leaving a 12px sliver; padding moved to a
  grandchild so `0fr` collapses fully.

## Portfolio section → interactive segment explorer

- Homepage "Five product segments" grid replaced on `lg+` by an
  **explorer**: a numbered index list on the left; hovering or
  keyboard-focusing a row activates it (teal index, left accent bar,
  arrow slides in) and the sticky preview panel on the right swaps to
  that segment's icon, name, count, intro and two CTAs
  ("Explore category" → landing page, "Product list" → catalogue).
  Rows stay real links — click navigates directly, no dead interaction.
- Preview replays the existing `.explorer-panel` fade-rise on each
  change (`key` remount); already covered by the reduced-motion reset.
- Below `lg` the existing numbered card grid remains — the explorer's
  two-column split doesn't fit a phone.
- Rows carry `data-segment` for unambiguous browser targeting.

## Section modernisation — floating stats, decorated dark sections

- **Stats band → floating card:** the flat teal strip became a white
  `rounded-3xl` card lifted into the hero/about seam (`-mt` + `z-10`),
  hairline column dividers, `Stat` gains `tone="light"` (ink numerals,
  brand-700 captions) while the dark Markets stats keep the default.
- **Ring motif as a system:** the faint concentric-ring decoration
  from the About fact panel now carries through the Global presence
  section (rings + a soft `brand-500` radial glow) and the CTA band —
  the site's dark moments now share one visual language.
- **Hover depth:** market chips, certification tiles and testimonial
  cards get `-translate-y-0.5` + border/shadow transitions
  (transform/shadow only, explicit properties — no `transition-all`).

## Header condense, hero parallax, de-duplicated imagery

- **Header:** the utility topbar folds away on scroll
  (`grid-template-rows: 1fr→0fr` transition — no JS height measuring),
  leaving a compact pinned nav with the existing floor shadow. Contact
  button picks up the `btn-cta` sheen. Reduced-motion: collapse is
  instant.
- **Hero scroll effect:** the facility image drifts ±20px inside its
  frame via `useScrollProgress` (transform-only, overscanned at
  scale-1.15 so edges never show; reduced-motion parks it covered). A
  faint offset `brand-200` ring sits behind the frame — editorial
  detail.
- **Duplicate imagery fixed:** `facility-aerial.webp` was the default
  for hero, about, overview and facility images — appearing twice on
  the homepage alone. The About preview now shows a photo card only
  when `about_image` differs from `hero_image` (admin-uploaded
  distinct photo); otherwise it renders a **company fact panel** —
  "Since 1998" figure plus facility/cert/market facts on a
  `brand-800→ink-950` gradient. Admin field stays meaningful, the
  page stops repeating itself.
- Inner pages (About, Manufacturing) keep the aerial in facility
  context — admin can swap any slot from Page content.

## Homepage composition — editorial split hero, indexed categories

- Hero reworked from full-bleed photo + heavy scrim to a **split
  editorial layout**: content on the left over a light
  `brand-50 → white` gradient, facility image framed right in a
  `rounded-3xl` card with a `MapPin` location chip
  (`{city}, {country}`). The real photo now reads as an asset instead
  of a dimmed backdrop.
- `CategoryCard` gains an `index` prop — cards show a muted two-digit
  editorial index (`01`–`05`) top-right, icon tile shrinks to 11×11,
  product count moves beneath the title as a caption. Applied on both
  the home portfolio grid and the products index.
- Home CTA band switched to a centered editorial composition (centered
  h2 + lead + CTA pair) on the `brand-800→950` gradient.
- About preview mirrored (image left, text right) so consecutive
  split sections alternate rather than repeat.
- Dead `.hero-media`/`hero-settle` CSS removed; `.reveal-media` added
  to the `prefers-reduced-motion` reset so media reveals collapse
  cleanly with the rest of the motion system.

## Theme refinement — cleaner teal, brighter CTAs, fixed blank button

- Brand teal ramp recalibrated for cleaner chroma (`brand-50–950` —
  same hue family, less grey/mud). Identity preserved.
- Primary CTAs step up to `bg-brand-600 → hover:brand-700` (was
  `700 → 800`) — brighter, more confident actions sitewide.
- Large teal fills get subtle directional depth: home CTA band, stats
  band and Inside CTA use `brand-700→900` gradients; product/blog/FAQ/
  market CTA cards use `brand-700→900` diagonal gradients. Flat slabs
  gone.
- **Bug fixed:** the home CTA "WhatsApp us" button rendered blank —
  `variant="outline"` painted `bg-white` while the override set
  `text-white`, hiding the label. New `outlineLight` ButtonLink variant
  (transparent bg, white border/text) is the correct dark-surface style;
  button also gates on `cta_whatsapp_label` being set.

## Inter typography system

- Sitewide font swapped from Manrope to **Inter** (`@fontsource/inter`,
  self-hosted weights 400/500/600/700 — no external requests).
  `--font-sans` is now `'Inter', Arial, sans-serif`.
- New `.t-*` scale in `app.css` is the single source of truth:
  `t-hero` (34→54px), `t-page` (30→44), `t-h2` (28→36), `t-h3` (22→26),
  `t-h4` (20), `t-lead` (18), `t-body` (16/1.6), `t-caption` (13),
  `t-eyebrow` (12/uppercase/0.04em), `t-nav` (15/500),
  `t-button` (15/600), `t-figure` (display numerals, 700).
- Headings now set at **semibold 600** site-wide (was extrabold 800);
  700 kept only for display numerals/initials. Uppercase label tracking
  tightened to `0.04em` (was 0.1–0.28em); label size floor is 12px.
- `prose-nymak`/`richtext-body`, spec-table headers, nav, buttons,
  cards, forms and footer all consume the same tokens — no
  page-specific type declarations remain.
- Client spec: Cipla-reference restraint — hierarchy from weight and
  scale, not decoration. No layout/palette/structure changes.

## Airline-style globe + site-wide design polish

- `/global-presence` rebuilt as an **interactive globe**: orthographic
  projection centred on the Indian Ocean with India as the visual hub,
  Mundra HQ marker, and animated gold supply-route arcs to every market —
  the airline-map read. Auto-rotates slowly (paused on hover/focus and for
  `prefers-reduced-motion`), draggable, and clicking a country — or a
  region-list row — flies the globe to it while the portfolio panel opens.
  Clearing a selection returns to the India hub view.
- Site-wide polish pass (clinical palette + Manrope preserved):
  consistent `:focus-visible` ring; nav underline sweep + active state;
  page-enter transition on Inertia swaps; dropdown/mobile-menu entrances;
  hero photo lifts to 50% with a settle animation; stats get hairline
  dividers + tabular numerals; category/product/post cards get a top
  accent hairline, explicit transition properties (no `transition-all`)
  and product counts; section eyebrows gain a rule mark; product spec
  tables become hairline ledgers with tabular numerals; editorial
  `reveal-media` clip reveal for feature images.
- Product bugs found by real-Chrome UAT: decorative route arcs were
  rendered above countries and swallowed clicks (`pointer-events: none`
  on the group + `aria-hidden`), and clearing a far-side selection left
  the globe facing away from keyboard targets. Both fixed with Vitest +
  UAT coverage.

## Product catalogue restructure — company home page, content-led categories

- The homepage no longer leads with a product grid: it is a company page —
  hero, stats, about, **category cards**, quality, global presence,
  testimonials, clients, FAQs, journal, contact CTA. The branded-products
  section still exists but ships **off by default** behind a Page content
  toggle (`show_brands`).
- New catalogue hierarchy, keeping the live site's category URLs:
  `/products` (overview) → `/product/{category}` (landing page with
  WYSIWYG-authored body, range summary, link to the list) →
  `/product/{category}/products` (grouped spec tables + in-page search) →
  `/product/{category}/{product}` (detail pages, `has_detail_page` only).
- Product detail pages dropped "Request a Quote" — the CTA is
  **"Contact us about this product"**, deep-linking to `/contact?product=…`
  which pre-selects the enquiry form. CTA labels, the related-products block
  and the support banner are Page content slots.
- `PageContent` gained `toggle` and `richtext` slot types; the home schema
  now exposes per-section show/hide switches plus every label. New schemas:
  `products.index`, `products.category`, `products.catalogue`,
  `products.show`.
- Categories gained `content` (sanitised HTML) + `image` columns, editable
  from Admin → Categories with the same lazy TipTap editor as markets.
- `NormalizeUrls` middleware: every trailing-slash URL 301s to the clean
  path; indexed legacy URLs (`/about-us/`, `/contact-us/`, `/iv-fluid/`)
  resolve in a single hop. Interim `/products/{category}[/{product}]` URLs
  301 to `/product/…`. Sitemap lists category + product-list URLs; llms.txt
  links both levels.
- Related-product links now point at each product's own category (was the
  current category — could 404 under scoped bindings).
- Tests: `PagesTest` grew to 14 (redirects, toggles, catalogue, no-quote
  detail); `AdminCrudTest` covers category rich-content sanitisation +
  page-content toggles; new real-Chrome journey
  `tests/Browser/product-hierarchy.mjs` (12 steps).

## Interactive Global Presence map + admin WYSIWYG

- `/global-presence` is now built around a live world map (SVG, d3-geo +
  world-atlas — no tiles or API keys, server-rendered). Countries we work in
  are highlighted (key markets stronger), hover shows a summary card, and
  clicking a country opens a detail panel with **what we do there**: rich
  content, supplied products and the local office. Region list mirrors the
  selection; keyboard operable; `#slug` deep links; mobile scrolls the panel
  into view. Markets without a single country (South Pacific Islands) are
  pinned by coordinates.
- Admin → Markets: country picker (ISO alpha-2 → map shape), TipTap WYSIWYG
  for the market content (`Field` type `richtext`, lazy-loaded), optional
  latitude/longitude pin. Content is sanitised server-side
  (`App\Support\Html`, symfony/html-sanitizer) in a model mutator so raw
  HTML is safe to render.
- Schema: `markets.content`, `markets.latitude`, `markets.longitude`.
  Page-content slots for the map section + footprint stats.
- Admin `Field` now puts the `id` on the control itself, so labels are
  properly associated (was on a wrapper span).
- Tests: `GlobalPresenceMapTest` (7), `WorldMap.test` (7), and a real-Chrome
  UAT journey `tests/Browser/global-presence-map.mjs` (15 steps).

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
- Full SEO control: per-entity meta fields (products, categories, markets,
  posts), cover images for articles (feeds OG + Article schema), and
  `page_metas` overrides for all static/list pages via `/admin/seo-pages`.

### Tests
- 49 PHP + 18 React tests — all green.

## Unreleased — CMS layer

- Page content editor (`/admin/pages`): every public page's copy and images
  editable via `page_contents` slot overrides with schema defaults; JSON
  slots cover repeating lists (timeline, capability cards, dosage forms).
- Site settings (`/admin/settings`): tagline, NAP, socials, stats and
  overseas offices merged over `config/nymak.php` via `SiteSetting::merged()`
  — feeds layout NAP, Organization schema, Contact and llms.txt.
- Client logos (`/admin/clients`): new `client_logos` entity; home strip now
  renders from DB instead of a hardcoded filename list.
- Team photos + certification badge uploads via new `image` field type in the
  shared CRUD layer (thumbnail columns, WebP conversion, old-file cleanup).
- `HandleInertiaRequests` site prop, `Seo::organizationSchema` and all
  `config('nymak…')` public reads now resolve through `SiteSetting::merged()`.

### Tests
- 62 PHP + 18 React tests — all green.

### Team pages & interactive story
- `/team` index + `/team/{slug}` profile pages (Person schema, bio-gated —
  no thin profiles), seeded with real bios from nymakpharma.com.
- `/inside-nymak`: interactive company story — authored journey rail,
  scroll-reveal motion, animated stat counters, and a market explorer
  (country selector → supplied-products panel).
- Global Presence is now a portfolio: markets render as expandable
  "what we did there" entries with supplied products; per-country
  pages removed (`has_page` → `show_in_portfolio`).
- Motion layer: `Reveal`/`CountUp` primitives (IntersectionObserver +
  CSS, reduced-motion aware), CTA sheen/arrow treatment, staggered
  card grids on Home.
- Page copy defaults synced to nymakpharma.com wording; llms.txt
  generated from settings + catalogue.

### Tawk.to live chat wired to client property
- `tawk_property` site setting set to the client's widget
  (`6ac51d4850bdca34caf61447/1k48vkpms`) — the right-side FAB lazily
  embeds the official Tawk.to loader on first click, maximizes the
  chat, and hides Tawk's own bubble on minimize so the themed FAB
  stays the single launcher. Falls back to `/contact` if the setting
  is cleared.

### Country flags + tappable market tiles
- Self-hosted flag SVGs in `public/images/flags/` (one per market ISO
  code); new `CountryFlag` component renders the flag chip with a
  Globe2 fallback when a market has no ISO code or the file is absent.
- Home "From Mundra to N+ country markets" tiles are now links:
  flag + country + region sub-label, deep-linking to
  `/global-presence#{slug}` so the globe opens with that market
  pre-selected; the "+N more" tile links to the explorer too.
- Flags also added to the Global Presence market panel title,
  quick-pick chips, and the region list.

### Brochure FAB polish
- Raised 5px (bottom 77px), FileDown icon with a red "PDF" corner
  badge, expanded label reads "Brochure · PDF", icon download-dip on
  hover; attention ring recolored to the brand green.

### Chat FAB "We're here" nudge
- Small speech bubble above the live-chat FAB (online dot + "We're
  here"), pops in ~1.6s after load and floats gently; part of the
  button so tapping it also opens Tawk. Reduced-motion safe.

### WhatsApp brand icon
- Shared `WhatsAppIcon` (official glyph) replaces the generic
  MessageCircle on the left FAB, the Contact "Chat on WhatsApp"
  link, and the WhatsApp CTAs on Global Presence and Home.

### Tawk.to native widget
- Switched from the custom themed FAB to Tawk.to's own default
  launcher: the official embed now loads on every page (still gated
  by the `tawk_property` admin setting), so visitors see Tawk's
  native green bubble + greeting card ("Hi! How can we help?") with
  unread badge, minimize bubble, etc. Custom FAB and nudge removed.

### Centered, tighter page heroes
- `PageHero` now centers by default (breadcrumbs, eyebrow, title,
  lead) on every page — was left-aligned; vertical padding reduced
  from py-14/20 to py-9/12 to remove the dead space under the
  breadcrumb.

### Breadcrumb left, title center
- PageHero breadcrumbs moved out of the centered block to the
  container's left edge — eyebrow/title/lead stay centered (light
  and dark heroes alike).

### Team page redesign + portrait placeholders
- `MemberPortrait` component: member photo when uploaded, else a
  designed duotone tile (alternating brand green/logo blue by
  index, concentric-ring motif, big initials, top sheen) — reads as
  art direction, not missing imagery. Same tile on the profile page
  hero and gradient initials circles in "More of the team".
- Cards are now full-bleed 4:5 portraits with a bottom gradient
  name bar (name + role); excerpt + "Full profile" reveal on hover,
  initials fade back on hover so text stays clean; image zooms.
- Section titles switched to the shared gradient SectionHeading;
  closing "Partnerships start with a conversation" CTA added;
  overlay text scales down on mobile so 2-col cards stay readable.

### Real team photos from nymakpharma.com
- Downloaded all 11 member portraits from the live site into
  `public/images/team/{slug}.png` and wired them in the DB + seeder
  (`photo` now set from the file when it exists).
- MemberPortrait renders the photo as a centred circle on the
  duotone tile (matches the round-crop format the assets ship in);
  initials remain the fallback for members without a photo.
- Fixed name spelling to match the live site: Murtaza → Murtuza
  Naqvi (slug updated to `murtuza-naqvi`).

### About: founder story section
- New "Our Story" block on /about — archival photographs downloaded from
  nymakpharma.com: the founder at the first office (c. 1998), an early
  consignment bound for Lae PNG, and the first container dispatch.
- Narrative + signature card (links to /team/ranjit-advani) sit beside the
  photo stack; all text, captions and images are admin-editable slots in
  PageContent::SCHEMA ('about'), with a show_story toggle.
- Mobile order: narrative first, photo stack below.
- Story imagery restyled as a collage matching the live site's treatment:
  brand "25+ Years of lifecare" badge overlapping the founder photo's
  top-left, and the two archival prints overlapping the bottom-right as
  lightly rotated polaroid cards (badge text is admin-editable).

### Enquiry spam-gate hardening
- `looksLikeSpam()` no longer treats negative elapsed time as spam —
  a client clock ahead of the server (skew) previously flagged every
  such submission, returning fake success while storing nothing.
- Spam-gate discards now Log::info the reason (honeypot vs min_time),
  email and IP, so real submissions caught by the gate stay diagnosable.
- Honeypot input gets 1Password/LastPass/autofill ignore attributes so
  form-fillers can't trip it for real users.
- Regression test: future form_started_at timestamps still store.
