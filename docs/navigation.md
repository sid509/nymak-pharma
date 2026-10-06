# Navigation — FROZEN

Status: **Proposed, pending client sign-off** (workbook sheet `4. Navigation`). Once
approved, this structure is frozen — changes only on client request or a genuine
functional/technical issue.

## 1. Existing navigation (nymakpharma.com — audited 2026-09-25)

### Header
| # | Item | Destination |
|---|------|-------------|
| 1 | Home | `/` |
| 2 | About Us | `/about-us/` |
| 3 | Products | `/iv-fluid/` → 301 → `/product/iv-fluids/` (hard-wired to one category) |
| 4 | Team | `/team/` |
| 5 | Global Presence | `/global-presence/` |
| 6 | Contact Us (button) | `/contact-us/` |

No dropdowns. No Manufacturing / Quality / Blog / FAQs entries.

### Footer
- **Quick Links:** About Us · Products · Global Reach · Team · Contact Us
- **Product Categories:** IV Fluids · Finished Formulations · Medical Devices & Disposables · Rapid Diagnostic Kits · Vaccines
- **Get Connected:** +91 98252 25567 · info@nymakpharma.com · Mundra address
- **Bottom bar:** © 2026 Nymakpharma · Powered by Vox360 · floating WhatsApp button

## 2. Proposed navigation (new site — implemented)

### Header (`resources/js/Components/Header.jsx`)
Utility bar (dark): `WHO-GMP Certified · Star Export House · Exporting to 24+ Countries` + phone + email.

| # | Item | Destination | Change |
|---|------|-------------|--------|
| 1 | Home | `/` | Same |
| 2 | About Us | `/about` | URL shortened (301 from `/about-us/`) |
| 3 | Products ▾ | `/products` + dropdown | **Restructured** — was hard-wired to IV Fluids |
| 3a | ▸ All Products | `/products` | New overview page |
| 3b | ▸ IV Fluids | `/product/iv-fluids` | Same path as live site (slash dropped, 301) |
| 3c | ▸ Finished Formulations | `/product/finished-formulations` | Same path as live site |
| 3d | ▸ Medical Devices & Disposables | `/product/medical-devices-and-disposables` | Same path as live site |
| 3e | ▸ Rapid Diagnostic Kits | `/product/rapid-diagnostic-kits` | Same path as live site |
| 3f | ▸ Vaccines & Antisera | `/product/vaccines` | Same path as live site; label adds "& Antisera" |
| 4 | Manufacturing | `/manufacturing` | **New item** |
| 5 | Quality | `/quality-certifications` | **New item** |
| 6 | Global Presence | `/global-presence` | Same URL (minus trailing slash) |
| 7 | Team | `/team` | Same URL (minus trailing slash) |
| 8 | Inside Nymak | `/inside-nymak` | **New item** |
| 9 | Blog | `/blog` | **New item** |
| 10 | Contact Us (button) | `/contact` | URL shortened (301) |

The Products dropdown is populated from `nav.categories` (the five seeded
categories, ordered by `sort_order`) — adding a category in admin updates the menu.

### Footer (`resources/js/Components/Footer.jsx`)
- **Brand column:** logo, "25+ years of efficacy-driven lifecare…" summary, social icons (LinkedIn, Instagram, X — suppressed if empty in `config/nymak.php`)
- **Company:** About Us · Manufacturing · Quality & Certifications · Global Presence · Blog & Resources · FAQs · Contact Us
- **Products:** All Products + the five categories (same source as header dropdown)
- **Get in Touch:** full NAP block (address, phone, email) from `config/nymak.php`
- **Bottom bar:** © {year} Nymak Pharma Private Limited · Privacy Policy · Terms of Use · Brochure (PDF) · Sitemap (sitemap.xml)

### Utility routes (not in menus)
`/sitemap.xml` · `/llms.txt` · `/robots.txt`

## 3. Rationale for changes

- **Products → dropdown** — the old header sent "Products" only to IV Fluids,
  hiding four of five categories. Now an overview page + all categories.
- **Manufacturing, Quality, Blog added** — required core pages per
  `Requirements/requirements.md` §9.
- **Inside Nymak** — signature story page of the approved design.
- **FAQs** exists but is footer-only (not a header item — keeps the header to 10 items).

## 4. Freeze rules

Do NOT change labels, order, items or destinations without client approval.
Admin-editable catalogue items (product categories) may reorder inside the
dropdown only via their `sort_order`.
