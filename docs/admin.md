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
| Categories | `/admin/categories` | Edit only — name, icon, intro, description, SEO, sort. Create/delete intentionally absent (structural; map to URLs/nav) |
| Markets | `/admin/markets` | Full CRUD; `has_page` controls the public `/global-presence/{slug}` page; delete blocked while products reference the market |
| Articles | `/admin/posts` | CRUD + draft/publish via `published_at`; markdown body; SEO fields |
| FAQs | `/admin/faqs` | CRUD via shared CRUD controller |
| Testimonials | `/admin/testimonials` | CRUD via shared CRUD controller |
| Certifications | `/admin/certifications` | CRUD via shared CRUD controller |
| Team | `/admin/team-members` | CRUD + `is_leadership` flag via shared CRUD controller |
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
  `Pages/Admin/Crud/Index.jsx` + `Form.jsx` render any module.
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
