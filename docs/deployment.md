# Deployment

Production shape: PHP-FPM + web server (nginx/Apache) + a supervised Node SSR
process + a queue worker. SQLite is fine to start; MySQL/PostgreSQL is a
drop-in env change when needed.

## Build

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build            # produces public/build + bootstrap/ssr
php artisan migrate --force --seed
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Processes to supervise

```bash
# 1. PHP — via php-fpm behind nginx, or `php artisan serve` for small deploys

# 2. SSR (required for full SEO) — systemd example:
php artisan inertia:start-ssr    # listens on 127.0.0.1:13714

# 3. Queue worker (for enquiry notification emails):
php artisan queue:work --tries=3
```

Supervisor/systemd units for `inertia:start-ssr` and `queue:work` should
restart on failure. If SSR is down the site degrades gracefully (meta still
served, body hydrates client-side) but restore it for full SEO.

## Environment

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.nymakpharma.com
DB_CONNECTION=sqlite  # or mysql/pgsql
DB_DATABASE=/absolute/path/database.sqlite
QUEUE_CONNECTION=database
MAIL_MAILER=smtp      # + MAIL_HOST/PORT/USERNAME/PASSWORD/ENCRYPTION
MAIL_FROM_ADDRESS=noreply@nymakpharma.com
NYMAK_MAILTO=info@nymakpharma.com
NYMAK_GA4_ID=G-XXXXXXX
NYMAK_GSC_VERIFICATION=...
NYMAK_ADMIN_EMAIL=...
NYMAK_ADMIN_PASSWORD=...   # set before first --seed
```

## Web server notes

- Serve `public/` as docroot; all non-file requests → `index.php`.
- **HTTPS required** (requirement #14) — redirect http→https, set HSTS.
- Long-cache `public/build/` and `public/images/` (they're content-hashed /
  immutable). Gzip/brotli text assets.
- `robots.txt`, `llms.txt`, `favicon.svg`, `images/` are static files under `public/`.

## DNS / email deliverability (requirement #18)

Verify on the domain provider (outside this codebase):

- **SPF** — `v=spf1` including the sending host/provider.
- **DKIM** — enabled on the mail provider for `nymakpharma.com`.
- **DMARC** — `v=DMARC1; p=quarantine` (or stricter) with a `rua` mailbox.
- Keep `info@nymakpharma.com` and `nymakpharma.com` on an authenticated sender.

## Post-deploy SEO checklist

- [ ] HTTPS + www/non-www canonicalization consistent
- [ ] `/sitemap.xml` returns XML with absolute production URLs (APP_URL drives them)
- [ ] Submit sitemap in Google Search Console; add `NYMAK_GSC_VERIFICATION`
- [ ] Set `NYMAK_GA4_ID`; verify `contact_click`/`generate_lead` events in GA4
- [ ] Run PageSpeed Insights mobile — target 90+ (WebP assets are already optimized)
- [ ] Confirm `curl -A "Googlebot" https://…/` returns content (SSR running)
- [ ] Create/verify LinkedIn, then set social URLs in `config/nymak.php`
