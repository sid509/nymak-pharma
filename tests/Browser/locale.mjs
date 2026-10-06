/**
 * Real-browser UAT for the multilingual public site (en / fr / es).
 *
 *   NYMAK_ADMIN_PASSWORD=… node tests/Browser/locale.mjs
 *
 * Requires the app on BASE_URL (default http://localhost:8000). Drives real
 * Chrome like a visitor + operator:
 * 1. Locale chrome — /fr and /es pages render translated UI, html lang,
 *    hreflang alternates and locale-prefixed nav links.
 * 2. Language switcher preserves the current path across locales.
 * 3. Contact form posts from /fr/contact and lands back on /fr/contact with
 *    the localized success message.
 * 4. Admin saves a French product name → it renders on the live /fr page,
 *    English stays canonical — then the translation is cleared again so the
 *    run is non-destructive.
 */
import { chromium } from 'playwright';

const BASE = process.env.BASE_URL ?? 'http://localhost:8000';
const EMAIL = process.env.NYMAK_ADMIN_EMAIL ?? 'admin@nymakpharma.com';
const PASSWORD = process.env.NYMAK_ADMIN_PASSWORD;
if (!PASSWORD) throw new Error('Set NYMAK_ADMIN_PASSWORD');

const stamp = Date.now().toString(36);
const marker = `UATFR-${stamp}`;
const results = [];
const step = async (name, fn) => {
    try { await fn(); results.push(['PASS', name]); console.log('PASS', name); }
    catch (e) { results.push(['FAIL', name, e.message]); console.log('FAIL', name, '\n   ', e.message.split('\n')[0]); }
};
const expect = (cond, msg) => { if (!cond) throw new Error(msg); };
const expect_text = async (page, text) => {
    await page.getByText(text, { exact: false }).first().waitFor({ timeout: 5000 });
};
const until = async (fn, msg) => {
    const deadline = Date.now() + 5000;
    while (Date.now() < deadline) {
        if (await fn()) return;
        await new Promise((r) => setTimeout(r, 120));
    }
    throw new Error(msg);
};

const browser = await chromium.launch({ channel: process.env.BROWSER_CHANNEL ?? 'chrome', headless: !process.env.HEADED });
const page = await browser.newPage({ viewport: { width: 1360, height: 900 } });
const errors = [];
page.on('pageerror', (e) => errors.push(e.message));

// ── Locale chrome ───────────────────────────────────────────────────
await step('English page serves English chrome, unprefixed', async () => {
    await page.goto(`${BASE}/products`);
    expect(await page.locator('html').getAttribute('lang') === 'en', 'html lang not en');
    await page.locator('header').getByRole('link', { name: 'Products', exact: true }).first().waitFor();
});

await step('French page serves French chrome under /fr', async () => {
    await page.goto(`${BASE}/fr/products`);
    expect(await page.locator('html').getAttribute('lang') === 'fr', 'html lang not fr');
    await page.locator('header').getByRole('link', { name: 'Produits', exact: true }).first().waitFor();
});

await step('Spanish page serves Spanish chrome under /es', async () => {
    await page.goto(`${BASE}/es/products`);
    expect(await page.locator('html').getAttribute('lang') === 'es', 'html lang not es');
    await page.locator('header').getByRole('link', { name: 'Productos', exact: true }).first().waitFor();
});

await step('hreflang alternates exist for all locales + x-default', async () => {
    const links = await page.locator('link[rel="alternate"][hreflang]').evaluateAll(
        (els) => els.map((el) => [el.getAttribute('hreflang'), el.getAttribute('href')]));
    const langs = Object.fromEntries(links);
    for (const l of ['en', 'fr', 'es', 'x-default']) expect(langs[l], `missing hreflang ${l}`);
    expect(langs['en'].endsWith('/products'), 'en alternate wrong');
    expect(langs['fr'].includes('/fr/products'), 'fr alternate wrong');
    expect(langs['es'].includes('/es/products'), 'es alternate wrong');
});

await step('nav links stay inside the current locale', async () => {
    await page.goto(`${BASE}/fr/products`);
    const hrefs = await page.locator('header a[href]').evaluateAll((els) => els.map((el) => el.getAttribute('href')));
    const internal = hrefs.filter((h) => h && h.startsWith('/') && !h.startsWith('//'));
    expect(internal.length > 3, 'not enough internal links to verify');
    const bad = internal.filter((h) => !h.startsWith('/fr'));
    expect(bad.length === 0, `links escaped /fr: ${bad.join(', ')}`);
});

// ── Language switcher ───────────────────────────────────────────────
await step('language switcher preserves the current path', async () => {
    await page.goto(`${BASE}/fr/about`);
    // The switcher is a dropdown — open it, then pick the locale link.
    await page.locator('header').getByRole('button', { name: /choose language/i }).first().click();
    await page.getByRole('link', { name: 'Español' }).first().click();
    await page.waitForURL(/\/es\/about/);
    expect(await page.locator('html').getAttribute('lang') === 'es', 'did not land on es');
    await page.locator('header').getByRole('button', { name: /choose language/i }).first().click();
    await page.getByRole('link', { name: 'English' }).first().click();
    await page.waitForURL(/\/about$/);
    expect(await page.locator('html').getAttribute('lang') === 'en', 'did not land back on en');
});

// ── Contact form under a locale ─────────────────────────────────────
await step('contact form posts and returns in French', async () => {
    await page.goto(`${BASE}/fr/contact`);
    await page.locator('#f-name').fill('Jean UAT');
    await page.locator('#f-company').fill('Distrib Test');
    await page.locator('#f-email').fill('uat-fr@example.com');
    await page.locator('#f-phone').fill('+33 600 000 000');
    await page.locator('#f-country').fill('France');
    await page.locator('#f-subject').fill('Demande UAT');
    await page.locator('#f-message').fill('Bonjour — ceci est un test UAT depuis la page française.');
    const cb = page.locator('form input[type="checkbox"]').first();
    if (await cb.count()) await cb.check();
    await page.getByRole('button', { name: /envoyer|send|soumettre/i }).first().click();
    await until(async () => page.url().includes('/fr/contact') &&
        (await page.locator('body').innerText()).includes('Merci'), 'no French success flash');
});

// ── Admin edits a translation → live render ─────────────────────────
let productEditUrl = null;
let productPath = null;
await step('admin saves a French product name (restored after)', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);

    // The index paginates at 25 — walk the pages via the shared session
    // until a detail-page product turns up (page 1 may have none).
    let live = null, editHref = null;
    for (let pg = 1; pg <= 20 && !live; pg++) {
        const res = await page.context().request.get(`${BASE}/admin/products?page=${pg}`);
        const html = await res.text();
        const m = html.match(/data-page="app"[^>]*>([\s\S]*?)<\/script>/);
        const d = JSON.parse(m[1]);
        const p = (d.props.products?.data ?? []).find((x) => x.has_detail_page && x.category?.slug && x.slug);
        if (p) {
            live = `/product/${p.category.slug}/${p.slug}`;
            editHref = `/admin/products/${p.slug}/edit`;
        }
    }
    expect(live, 'no detail-page product found');
    productPath = `/fr${live}`;

    await page.goto(`${BASE}${editHref}`);
    await page.waitForURL(/\/admin\/products\/[^/]+\/edit/);
    productEditUrl = page.url();

    const fr = page.locator('[id="f-i18n.fr.name"]').first();
    await fr.waitFor({ timeout: 5000 });
    await fr.fill(marker);
    await page.getByRole('button', { name: /save|update/i }).first().click();
    await until(async () => (await page.locator('body').innerText()).match(/saved|success|updated/i), 'no save confirmation');

    await page.goto(`${BASE}${productPath}`);
    await until(async () => (await page.locator('body').innerText()).includes(marker), 'French name not rendered');
});

await step('English page still shows the canonical name', async () => {
    if (!productPath) throw new Error('no product path from previous step');
    const enPath = productPath.replace(/^\/fr/, '');
    await page.goto(`${BASE}${enPath}`);
    const body = await page.locator('body').innerText();
    expect(!body.includes(marker), 'English page leaked the French name');
});

await step('restored: clearing the French name reverts to English', async () => {
    if (!productEditUrl) throw new Error('no edit url');
    await page.goto(productEditUrl);
    const fr = page.locator('[id="f-i18n.fr.name"]').first();
    await fr.fill('');
    await page.getByRole('button', { name: /save|update/i }).first().click();
    await until(async () => (await page.locator('body').innerText()).match(/saved|success|updated/i), 'no save confirmation');
    await page.goto(`${BASE}${productPath}`);
    const body = await page.locator('body').innerText();
    expect(!body.includes(marker), 'French name still rendered after restore');
});

await step('sitemap carries the three locale variants', async () => {
    const res = await page.request.get(`${BASE}/sitemap.xml`);
    const xml = await res.text();
    expect(xml.includes('/fr/about'), 'sitemap missing /fr urls');
    expect(xml.includes('/es/about'), 'sitemap missing /es urls');
    expect(xml.includes('hreflang="x-default"'), 'sitemap missing x-default');
});

const badErrors = errors.filter((e) => !/tawk|embed\.tawk/i.test(e));
if (badErrors.length) console.log('PAGE ERRORS:', badErrors);

const failed = results.filter(([s]) => s === 'FAIL');
console.log(`\n${results.length - failed.length}/${results.length} passed`);
await browser.close();
process.exit(failed.length || badErrors.length ? 1 : 0);
