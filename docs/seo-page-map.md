# SEO Page Map — old site → new site

Audit date: 2026-09-25. Old site SEO state: pattern titles (`{Page} – Nymak Pharma Pvt.
Ltd.`), **no meta descriptions on any page**, no OG/Twitter tags, no structured data.
New site emits title + description + canonical + OG/Twitter + JSON-LD per page
(`docs/seo.md`).

## 1. URL & redirect map (301s required at launch)

| # | Old URL | New URL | Action | Redirect needed |
|---|---------|---------|--------|-----------------|
| 1 | `/` | `/` | Keep (redesigned) | No |
| 2 | `/about-us/` | `/about` | Rename | **301** |
| 3 | `/team/` | `/team` | Keep (trailing slash dropped) | **301** |
| 4 | `/global-presence/` | `/global-presence` | Keep (trailing slash dropped) | **301** |
| 5 | `/contact-us/` | `/contact` | Rename | **301** |
| 6 | `/product/iv-fluids/` | `/product/iv-fluids` | Keep (trailing slash dropped) | **301** |
| 7 | `/product/finished-formulations/` | `/product/finished-formulations` | Keep | **301** |
| 8 | `/product/medical-devices-and-disposables/` | `/product/medical-devices-and-disposables` | Keep | **301** |
| 9 | `/product/rapid-diagnostic-kits/` | `/product/rapid-diagnostic-kits` | Keep | **301** |
| 10 | `/product/vaccines/` | `/product/vaccines` | Keep | **301** |

> **URL decision (2026-10):** category pages stay at the live site's
> `/product/{slug}` — no move means no ranking reset. The new hierarchy adds
> one level beneath each category:
>
> - `/products` — overview (categories, no tables)
> - `/product/{category}` — content-led landing page (indexable body copy)
> - `/product/{category}/products` — the full grouped product list
> - `/product/{category}/{product}` — detail pages (`has_detail_page` only)
>
> Interim `/products/{category}[/{product}]` URLs from the previous build
> 301 to the canonical `/product/…` paths. All trailing-slash spellings 301
> to the clean path via the `NormalizeUrls` middleware (one hop for the
> legacy URLs below).

### Legacy redirects already live on the old site — must be re-pointed
| Old URL | Currently 301s to | Must now 301 to |
|---|---|---|
| `/iv-fluid/` (header "Products" target) | `/product/iv-fluids/` | `/product/iv-fluids` |
| `/product/iv-fluid/` | `/product/iv-fluids/` | `/product/iv-fluids` |
| `/product/finished-formulation/` | `/product/rapid-diagnostic-kits/` (**misconfigured**) | `/product/finished-formulations` — **fix** |
| `/product/finished-formulation-2/` | `/product/rapid-diagnostic-kits/` | `/product/rapid-diagnostic-kits` |
| `/product/medical-device/` | `/product/medical-devices-and-disposables/` | `/product/medical-devices-and-disposables` |

### Orphan posts — proposed removal (CLIENT APPROVAL REQUIRED)
`/how-private-clinics-improve-healthcare-access/` ·
`/how-private-clinics-improve-healthcare-access-2/` ·
`/personalized-medical-care-at-private-clinics/` ·
`/private-clinic-services-for-comprehensive-care/`
Off-topic demo posts, in wp-sitemap but linked nowhere. Recommend **410** (or 301 → `/blog`).

## 2. Titles & descriptions

Rendered title pattern: `{seo.title} | Nymak Pharma` (set in `app.blade.php`).

| Page (new URL) | Old title | Proposed title | Proposed meta description |
|---|---|---|---|
| `/` | Nymak Pharma Pvt. Ltd. | Pharmaceutical Manufacturer & Exporter in India \| Nymak Pharma | WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, medical devices, rapid test kits and vaccines to 24+ countries. |
| `/about` | About Us – Nymak Pharma Pvt. Ltd. | About Us — WHO-GMP Pharmaceutical Manufacturer Since 1998 \| Nymak Pharma | Founded in 1998, Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Star Export House serving 24+ countries from Mundra, Gujarat, India. |
| `/manufacturing` | — (new) | Pharmaceutical Manufacturing Facility — Mundra, Gujarat \| Nymak Pharma | Inside Nymak Pharma's WHO-GMP certified manufacturing facility in Mundra, Gujarat — in-house QC lab, QA systems, regulatory and warehouse teams. |
| `/quality-certifications` | — (new) | Quality & Certifications — WHO-GMP, ISO 13485 \| Nymak Pharma | Nymak Pharma's quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, Pharmexcil RCMC — with in-house QC/QA oversight. |
| `/products` | — (new) | Pharmaceutical Products — IV Fluids, Formulations & More \| Nymak Pharma | Explore Nymak Pharma's export portfolio: IV fluids, finished formulations, medical devices & disposables, rapid diagnostic kits and vaccines. |
| `/product/iv-fluids` | IV Fluids – Nymak Pharma Pvt. Ltd. | IV Fluids Manufacturer & Exporter in India \| Nymak Pharma | WHO-GMP certified IV fluids manufacturer in India supplying intravenous infusions — dextrose, saline, RL, mannitol & antibiotic infusions — to 24+ countries. |
| `/product/finished-formulations` | Finished Formulations – Nymak Pharma Pvt. Ltd. | Finished Formulations Manufacturer India \| Nymak Pharma | Pharmaceutical finished formulations manufacturer & exporter: tablets, capsules, syrups, injectables across antimalarial, antibiotic, ARV & chronic therapies. |
| `/product/medical-devices-and-disposables` | Medical Devices and Disposables – … | Medical Devices & Disposables Supplier India \| Nymak Pharma | Exporter of medical devices & surgical disposables from India: IV cannulas, syringes, infusion sets, catheters, gauze & gloves for hospitals & tenders. |
| `/product/rapid-diagnostic-kits` | Rapid Diagnostic Kits – … | Rapid Diagnostic Test Kits Manufacturer India \| Nymak Pharma | Rapid diagnostic kits exporter from India: malaria, HIV, HBsAg, HCV, syphilis, typhoid & pregnancy test kits for labs, NGOs & health ministries. |
| `/product/vaccines` | Vaccines – Nymak Pharma Pvt. Ltd. | Vaccines & Antisera Exporter India \| Nymak Pharma | Pharmaceutical vaccines & antisera supplier: snake venom antiserum and tetanus antitoxin exported from India to Africa, Asia & Central America. |
| `/global-presence` | Global Presence – … | Global Presence — Pharmaceutical Exports to 24+ Countries \| Nymak Pharma | Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, Central America & the South Pacific. |
| `/team` | Team – Nymak Pharma Pvt. Ltd. | Our Team — Leadership & Experts \| Nymak Pharma | Meet the leadership and specialists behind Nymak Pharma — exports, regulatory affairs, quality control, logistics and design. |
| `/team/{member}` ×11 | — (new) | {Name} — {Role} \| Nymak Pharma | First ~155 chars of the approved bio. |
| `/inside-nymak` | — (new) | Inside Nymak — An Interactive Story \| Nymak Pharma | An interactive walk through Nymak Pharma — from a 1998 startup in Mundra to an exporter trusted across 24+ countries. |
| `/blog` | — (new) | Insights & Resources \| Nymak Pharma | Company news, quality explainers and product insights from Nymak Pharma — a WHO-GMP certified pharmaceutical manufacturer and exporter. |
| `/blog/{post}` ×4 | — (new) | Per-post `meta_title` \| Nymak Pharma | Per-post `meta_description` (see PostSeeder / workbook). |
| `/faqs` | — (new) | Frequently Asked Questions \| Nymak Pharma | Answers about Nymak Pharma's products, IV fluids, certifications, export markets, quality systems and how to partner with us. |
| `/contact` | Contact Us – Nymak Pharma Pvt. Ltd. | Contact Us — Pharmaceutical Export Enquiries \| Nymak Pharma | Contact Nymak Pharma for pharmaceutical exports, product enquiries, distribution and partnership — offices in India, UK, Sierra Leone & Liberia. |
| `/privacy-policy` | — (404 on old site) | Privacy Policy \| Nymak Pharma | How Nymak Pharma collects, uses and protects personal data submitted through this website. |
| `/terms` | — (new) | Terms of Use \| Nymak Pharma | Terms governing the use of the Nymak Pharma website and its content. |
| `/product/finished-formulations/{brand}` ×46 | — (new) | {Product Name} \| Nymak Pharma | Product note + market (per-product pattern). |

## 3. On-page SEO checklist status

- **H1** — one per page via `PageHero` (React) — ✅ implemented
- **Canonicals** — absolute per page — ✅
- **Schema** — Organization + LocalBusiness + WebSite site-wide; BreadcrumbList on
  inner pages; FAQPage on `/` + `/faqs` + `/quality-certifications`; Product on
  branded detail pages; Article on posts — ✅ (all new; old site had none)
- **robots.txt** — `public/robots.txt`, disallows `/admin`, references sitemap — ✅
- **sitemap.xml** — dynamic, ~67 URLs — ✅
- **llms.txt** — generated — ✅ (new)
- **OG/Twitter cards** — per page — ✅ (new)
- **Image alt text** — descriptive alts on all new-site imagery — ✅ (old site had 12 missing alts)
- **Analytics** — GA4/GSC via env, `nymakTrack` events on form/tel/mailto/WhatsApp/brochure — ✅ (new)

## 4. Assets / imagery map

| Where | Asset | Source | Alt text |
|---|---|---|---|
| Home hero + page heroes | Facility aerial WebP | Client drone shots (`Resources/Nymak Office Drone Shot`) | "Nymak Pharma manufacturing facility, Mundra, Gujarat" |
| Brands band + detail pages | 46 pack-shot WebPs | `Resources/Nymak Product Pictures` (Liberia + SL folders) | "{Product} — {market} pack shot" |
| Quality page | Certificate scans | `Resources/Certification Logo`, `ISO Certificate`, `Star Export House` | "{Certificate} issued to Nymak Pharma" |
| Home logo marquee | 12 client logos | `Resources/Client Logos` | "{Partner name} logo" |
| Team | Member photos | `public/images/team` (if supplied) | "{Name}, {Role}" |
| Footer/contact | Brochure PDF | `Resources/Nymak Pharma Brochure.pdf` | link text "Download product brochure (PDF)" |
| **Asset required** | Facility video file for the old homepage video banner | Client to supply or confirm removal | — |
