# Admin Panel

Administrative interface for the Nymak Pharma site. Same Laravel app, same
database, same Inertia/React stack as the public site — it manages the shared
domain, it is not a separate application.

## Access

| | |
|---|---|
| URL | `/admin` (redirects to `/admin/dashboard`; `/admin/login` when logged out) |
| Credentials | Seeded from `NYMAK_ADMIN_EMAIL` / `NYMAK_ADMIN_PASSWORD` env |
| Session | Laravel session cookie, `auth` middleware, throttled login (`6/min`) |

Change a password in production via `/admin/profile` (requires the current
password) or:

```bash
php artisan tinker --execute="App\Models\User::first()->update(['password' => 'new-strong-password'])"
```

## Modules

| Module | Path | Capabilities |
|---|---|---|
| Dashboard | `/admin/dashboard` | Unread enquiry count, catalogue/content counts, actionable alerts (detail pages missing images, drafts), latest enquiries |
| Enquiries | `/admin/enquiries` | Search (name/email/company/country/subject), unread/read filter, expand to read, mark read/unread, delete, `mailto:`/tel reply links |
| Products | `/admin/products` | Search (name/strength/group), category filter, paginated; create/edit/delete; image upload (→WebP); `has_detail_page` publish flag; SEO fields; sort order |
| Categories | `/admin/categories` | Edit only — name, icon, intro, image, landing-page **content** (WYSIWYG, sanitised server-side — the indexable body of `/product/{slug}`), fallback description, SEO, sort. Create/delete intentionally absent (structural; map to URLs/nav) |
| Markets | `/admin/markets` | Full CRUD. Every market is a clickable country on the `/global-presence` interactive map (country picker stores the ISO code; markets without one — island groups — are pinned by latitude/longitude). **What we do in this market** is a WYSIWYG field (headings, lists, bold/italic, links) shown in the map's detail panel; HTML is sanitised server-side on save. `show_in_portfolio` = "Key market" (stronger highlight, listed with supplied products). Delete blocked while products reference the market |
| Articles | `/admin/posts` | CRUD + draft/publish via `published_at`; markdown body; SEO fields |
| FAQs | `/admin/faqs` | CRUD via shared CRUD controller |
| Testimonials | `/admin/testimonials` | CRUD via shared CRUD controller |
| Certifications | `/admin/certifications` | CRUD via shared CRUD controller; logo/badge image upload (→WebP, thumb in table) |
| Team | `/admin/team-members` | CRUD + `is_leadership` flag + photo upload + slug/bio/SEO fields; a bio gives the member a `/team/{slug}` profile page (Person schema); initials fallback when no photo |
| Client logos | `/admin/clients` | CRUD via shared CRUD controller — logo upload (→WebP) feeds the home-page client strip |
| Page content | `/admin/pages` | Per-page slots (`PageContent::SCHEMA`), types `text`/`textarea`/`richtext`/`image`/`json`/`toggle`: every headline, paragraph and image on Home/About/Manufacturing/Quality/Contact/Team/Inside Nymak, plus the products overview, category/list/detail layouts. **Toggles show/hide whole sections** (e.g. home stats, testimonials, FAQ, the branded-products grid which is off by default); `{category}`/`{count}` placeholders are filled at render. Blank text restores defaults; images upload →WebP |
| Site settings | `/admin/settings` | Company facts — tagline, phone/WhatsApp/email, addresses, stats, socials, overseas offices (JSON). `SiteSetting::merged()` layers rows over `config/nymak.php` and feeds header/footer NAP, Contact, schema.org and llms.txt |
| Admin users | `/admin/users` | Create/edit/delete admin accounts; self-delete blocked; optional password reset on edit |
| SEO pages | `/admin/seo-pages` | Meta title/description/OG-image overrides for the 11 static & listing pages; blanks fall back to controller defaults |
| Profile | `/admin/profile` | Change own password (`current_password` verified) |

## SEO coverage — every dynamic page is admin-editable

| Page type | Editable fields | Schema |
|---|---|---|
| Product detail | meta title, description, slug, image, `has_detail_page` | `Product` — auto-derived from name/description/image |
| Category | meta title, description, intro, body, icon, sort | `ItemList`/`BreadcrumbList` — auto |
| Market page | meta title, description, slug, `has_page`, body | `BreadcrumbList` — auto |
| Article | meta title, description, slug, cover image, category, publish date | `Article` — auto-derived incl. cover image |
| Static/list pages (home, about, products index, blog index, markets index, FAQs, contact, legal…) | meta title, description, OG image via **SEO pages** module | `WebPage`/`FAQPage`/`BreadcrumbList` — auto |

Structured data is never hand-edited: JSON-LD is generated from the same
fields admins control, so it cannot drift out of sync or break validity.

## Architecture

```
Request ──> auth middleware ──> Admin/*Controller ──> Eloquent (shared models)
                                    │
                                    ├─ FormRequest (server-side validation)
                                    └─ Inertia::render('Admin/…')
```

- **Single role.** All authenticated users are admins. No role/permission
  matrix — see ADR-008. Authorization boundary is the `auth` middleware on the
  `/admin` route group; frontend never enforces security.
- **Shared CRUD.** `Admin\CrudController` provides index/create/store/edit/
  update/destroy; subclasses declare `model()`, `request()` and a `config()`
  (module name, table columns, searchable fields, form fields). The generic
  `Pages/Admin/Crud/Index.jsx` + `Form.jsx` render any module. Field type
  `image` adds upload→WebP with old-file cleanup; column type `image` renders
  a thumbnail in tables.
- **Page content slots.** `PageContent::SCHEMA` declares each public page's
  editable copy (text/textarea/image/json). Controllers resolve
  `PageContent::for($page)` — stored rows over declared defaults — into a
  `content` prop; React pages render exclusively from it. Admin edits publish
  on next request; blank text deletes the row (default restored).
- **Site settings.** `SiteSetting` rows are dotted keys merged over
  `config/nymak.php` by `SiteSetting::merged()`; the Inertia `site` prop,
  `Seo::organizationSchema()`, offices and stats all read through it, so an
  edit propagates everywhere at once.
- **Slug binding.** Admin URLs use the model's route key (slug for slugged
  models, id elsewhere). Public URLs are unaffected by admin edits.
- **Images.** `App\Support\ImageUpload` validates (real MIME, ≤2 MB),
  converts to WebP (≤1200 px) and writes to `public/images/<subdir>/` — the
  same convention as seeded assets. Replaced/deleted product images are
  unlinked from disk.
- **Delete guards.** Products with linked enquiries and markets with linked
  products return 422 instead of deleting. Admin self-delete is blocked.
- **Badges.** `admin.unreadEnquiries` is a shared Inertia prop computed only
  for authenticated requests (no extra query on public pages).

## SEO interaction

Admin edits land directly in public output: product/category/market/post meta
fields feed `Seo::make()`; `has_detail_page`/`has_page` control whether URLs
exist (and therefore the sitemap). Enabling a detail page without real content
is a content-quality decision, not a code gate — the UI hints at this.

## Testing

`tests/Feature/AdminCrudTest.php` covers the auth gate on every module,
dashboard props, product search/CRUD/upload/slug-unique, market delete guard,
post publish flow, generic CRUD round-trip, category slug immutability, user
management + self-delete guard, password change, enquiry search/filter.
`tests/Feature/AdminTest.php` covers login/logout/throttling basics.
