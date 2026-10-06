# Page Mapping — existing site → redesigned site

How every page of **www.nymakpharma.com** maps to the redesign. Content is
carried over unless marked otherwise; see `NYMAK_Pharma_Website_Content_Plan.xlsx`
for section-level write-ups and the Change Log for every edit.

| Existing page | Existing URL | New page | New URL | Action | Content source | Notes |
|---|---|---|---|---|---|---|
| Home | `/` | Home | `/` | Redesign | Existing approved content — presentation/layout redesign only; adds brands band, client logos, FAQ & journal previews (flagged) | Video banner pending client decision |
| About Us | `/about-us/` | About Us | `/about` | Restructure | Existing approved content — condensed into overview + timeline + values + credentials | "22→24+ countries", "26→25+ years" standardised to brochure — flagged |
| Team | `/team/` | Team | `/team` | Redesign | Existing approved content — same 11 members verbatim | Adds member detail pages; name-spelling flag (Murtuza/Murtaza) |
| Global Presence | `/global-presence/` | Global Presence | `/global-presence` | Redesign + expand | Approved paragraph verbatim + offices moved from Contact | Market list compiled from approved mentions; Ghana flagged |
| Contact Us | `/contact-us/` | Contact Us | `/contact` | Redesign | Existing approved content — addresses verbatim; form extended | Coral Marketing card + business hours + Liberia alt phone flagged |
| IV Fluids | `/product/iv-fluids/` | IV Fluids landing | `/product/iv-fluids` | URL preserved | Approved intro (condensed) + new editorial body; tables moved to `/product/iv-fluids/products` (26 products, 11 groups) | New description paragraph + enquiry CTA flagged |
| Finished Formulations | `/product/finished-formulations/` | Finished Formulations landing | `/product/finished-formulations` | URL preserved | Approved intro + new editorial body; tables moved to `/product/finished-formulations/products` (186 products, 30 groups) | + branded range section (approval); 2 typo fixes flagged |
| Medical Devices & Disposables | `/product/medical-devices-and-disposables/` | same | `/product/medical-devices-and-disposables` | URL preserved | Approved intro + editorial body; items under 4 headings at `/product/medical-devices-and-disposables/products` | "Neonates only" stray row dropped — flagged |
| Rapid Diagnostic Kits | `/product/rapid-diagnostic-kits/` | same | `/product/rapid-diagnostic-kits` | URL preserved | Approved intro + editorial body; table at `/product/rapid-diagnostic-kits/products` (20 kits) | — |
| Vaccines | `/product/vaccines/` | Vaccines & Antisera | `/product/vaccines` | URL preserved | Approved intro + editorial body; table at `/product/vaccines/products` (4 products) | Display name change flagged |
| *(new)* | — | Products overview | `/products` | New Page | New copy over approved catalogue | Approval required |
| *(new)* | — | Manufacturing | `/manufacturing` | New Page | Assembled from approved facility facts + testimonial quotes | Approval required |
| *(new)* | — | Quality & Certifications | `/quality-certifications` | New Page | Approved certificates strip + new microcopy | Approval required |
| *(new)* | — | Inside Nymak | `/inside-nymak` | New Page | New — timeline dates 2002–2022 illustrative | **Verify dates or reduce milestones** |
| *(new)* | — | Blog + 4 articles | `/blog` | New Page | New editorial derived from approved facts | Approval required |
| *(new)* | — | FAQs | `/faqs` | New Page | 12 Q&A from approved facts | Approval required |
| *(new)* | — | Privacy Policy | `/privacy-policy` | New Page | New legal copy | Legal review required |
| *(new)* | — | Terms of Use | `/terms` | New Page | New legal copy | Legal review required |
| *(new)* | — | Category product lists ×5 | `/product/{category}/products` | New Page | Same approved catalogue rows, grouped + searchable | Split from landing page for SEO depth |
| *(new)* | — | Branded product pages ×46 | `/product/{category}/{brand}` | New Page | Client pack shots + composition notes | Verify compositions; approval required |
| *(new)* | — | Team member pages ×11 | `/team/{member}` | New Page | Approved bios | Approval required |
| Orphan posts ×4 | `/how-private-clinics…`, `/personalized-medical…`, `/private-clinic-services…`, `/how-private-clinics…-2/` | — | — | Remove | Off-topic demo content, unlinked | **Client decision: 410 or 301 → /blog** |

## Notes on structure

- Old site had **no** products overview, manufacturing, quality, FAQ, blog, legal,
  or individual product/member pages — every one of those is a documented new
  addition and appears in workbook Sheet 3 with its reason.
- No existing page is dropped. The only removals proposed are the four orphan
  demo posts and two presentation artifacts (video banner, Coral Marketing card),
  all flagged for client decision.
- Trailing slashes: Laravel serves URLs without them; all old trailing-slash URLs
  301 to the new paths (see `docs/seo-page-map.md`).
