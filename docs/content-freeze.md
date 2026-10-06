# Content Freeze — NYMAK Pharma Redesign

Effective from the content audit of **2026-09-25**. Companion deliverable:
`NYMAK_Pharma_Website_Content_Plan.xlsx` (workspace root).

## Sources of truth

| Concern | Source of truth |
|---|---|
| **Content** | The existing website **www.nymakpharma.com** — confirmed by the client as up to date and approved. Existing wording is preserved wherever possible; where it was condensed or split across sections it is flagged in the workbook's Change Log. |
| **Design** | The approved redesigned implementation in `Sources/` (Laravel + Inertia React + Tailwind 4). Tokens and patterns documented in `docs/design-system.md`. |
| **Navigation** | `docs/navigation.md` — final structure, frozen. |
| **Company facts / NAP** | `Sources/config/nymak.php` (single source feeding footer, contact page, schema, llms.txt). Facts themselves originate from the approved website + client-supplied brochure. |
| **Product catalogue** | `Sources/database/seeders/ProductSeeder.php` — a verbatim port of the website's product tables; edits go through the admin panel or seeder + reseed. |

## Rules now in force

1. **No rewriting approved copy.** Restructure/present only. Any rewrite is marked "CLIENT REVIEW REQUIRED" in the workbook.
2. **No new facts.** Company claims, certifications, statistics, names, dates, addresses, phones, emails must already exist in approved material or client-supplied assets.
3. **New pages and new content are quarantined for approval.** Everything marked "New" in the workbook requires explicit client sign-off before it is treated as final.
4. **Navigation and design are frozen** per `docs/navigation.md` / `docs/design-system.md`.
5. **URLs change only via the redirect map** in `docs/seo-page-map.md`.

## Items that MUST NOT ship without client approval

From the Change Log (workbook sheet 5):

| # | Item | Why flagged |
|---|---|---|
| 1 | **Inside Nymak timeline dates (2002, 2004, 2006, 2008, 2010, 2012, 2014, 2016, 2018, 2020, 2022)** | These dated milestones are *not* documented on the current site — only 1998 (founding), 2000 (Nigeria) and FY 2023–24 figures are. Verify real dates or reduce to documented milestones. |
| 2 | **Branded range shown publicly** (Alumak, Cefmak, Cipromak, Clavmak, Zincomak + 41 more products; 46 detail pages) | Brands exist only in client-supplied pack shots, not on the current site. Confirm public display + verify each composition line. |
| 3 | **Client logo strip (12 logos)** | Partner logos were provided as assets but never shown on the site — confirm consent. |
| 4 | **12 new FAQs** | New copy assembled from approved facts — needs a read-through. |
| 5 | **4 new blog articles** | New editorial content derived from approved facts — needs sign-off. |
| 6 | **Privacy Policy & Terms of Use** | New legal copy — needs client/legal review (the current form already links a non-existent policy). |
| 7 | **Condensed About page** (7 paragraphs → 3 + timeline) | Figures standardised to brochure: "22 countries"→"24+", "26 years"→"25+". Confirm. |
| 8 | **Condensed category intros** (5 pages) | Longer approved paragraphs shortened for hero use — confirm. |
| 9 | **"Vaccines" → "Vaccines & Antisera" display name** | Products listed are antisera; slug unchanged. Confirm label. |
| 10 | **Team member detail pages (11)** | New page type reusing approved bios — confirm members consent. |
| 11 | **"Murtuza" vs "Murtaza" Naqvi spelling** | Draft uses "Murtaza"; current site "Murtuza" — confirm correct spelling. |
| 12 | **Ghana in market list** | Appears in the new markets list; not explicitly named on the current site — confirm Nymak serves Ghana. |
| 13 | **Coral Marketing card omitted from Contact** | 4th "Group Company" on the current page (+91 9687250541, info@coralmarketing.net) — reinstate or confirm removal. |
| 14 | **Business hours "Mon–Sat, 9:30–18:30 IST"** | New information on the contact card — verify. |
| 15 | **Liberia second phone (+231 777 736 498); Sierra Leone "1st Floor … (UP)" wording; postal code 370421** | Fuller contact details — verify before launch. |
| 16 | **Facility video banner (homepage)** | Present on the current site, not in the design — reinstate with file or confirm removal. |
| 17 | **4 orphan "private clinic" blog posts** | Off-topic demo content, unreachable from nav — proposed for removal/301. Confirm. |
| 18 | **Catalogue description paragraphs on the 5 category pages** | New summaries of approved tables added to meet the 300-word SEO minimum. |
| 19 | **Contact form new fields** (Company, Country, Product of Interest) | Changed lead-capture fields — confirm. |
| 20 | **Obvious typo fixes in product tables** | "Sulbutamol"→Salbutamol, "Prantoprazole"→Pantoprazole, "cathether"→catheter, "Butylbrome"→Butylbromide — factual corrections to verify. |
| 21 | **Chloroquine 100 mg / 250 mg rows consolidated; "Neonates only" stray row dropped** | Table tidy-ups — verify no product lost. |
| 22 | **New SEO titles + meta descriptions on every page** | Old site had pattern titles and zero descriptions — all new, need approval. |
| 23 | **URL changes + 301 redirects** | See `docs/seo-page-map.md` — confirm redirect plan. |

## Change-freeze workflow

- **Approved content edits** → admin panel (page slots, products, posts, FAQs…) or seeder + reseed.
- **Anything on the list above** → client sign-off recorded first, then implement.
- **New pages/sections/claims not in the workbook** → require a new approval round.
