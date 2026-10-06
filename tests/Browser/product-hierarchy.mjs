/**
 * Real-browser UAT for the product hierarchy restructure.
 *
 *   NYMAK_ADMIN_PASSWORD=… node tests/Browser/product-hierarchy.mjs
 *
 * Requires the app on BASE_URL (default http://localhost:8000). Drives real
 * Chrome like an operator:
 * 1. Admin flips a home-section toggle in Page content and edits a category —
 *    changes verified live, then restored.
 * 2. Visitor journey: home (categories, no product grid) → category landing
 *    → full product list → product detail → contact CTA (no quote flow).
 * 3. Redirect + canonical checks for the old URL shapes.
 * The admin-authored changes are restored at the end so the run is
 * non-destructive.
 */
import { chromium } from 'playwright';

const BASE = process.env.BASE_URL ?? 'http://localhost:8000';
const EMAIL = process.env.NYMAK_ADMIN_EMAIL ?? 'admin@nymakpharma.com';
const PASSWORD = process.env.NYMAK_ADMIN_PASSWORD;
if (!PASSWORD) throw new Error('Set NYMAK_ADMIN_PASSWORD');

const stamp = Date.now().toString(36);
const marker = `UAT-${stamp}`;
const results = [];
const step = async (name, fn) => {
    try { await fn(); results.push(['PASS', name]); console.log('PASS', name); }
    catch (e) { results.push(['FAIL', name, e.message]); console.log('FAIL', name, '\n   ', e.message.split('\n')[0]); }
};
const expect = (cond, msg) => { if (!cond) throw new Error(msg); };
/** Poll `fn` until truthy or ~5 s elapse. */
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

let originalIntro = null;

// ── Admin: controls actually control the live site ──────────────────
await step('admin can log in', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
});

await step('admin edits a category: richtext editor + intro, saved via the form', async () => {
    await page.goto(`${BASE}/admin/categories`);
    await page.getByRole('link', { name: 'Edit' }).first().click();
    await page.waitForURL(/\/admin\/categories\/[^/]+\/edit/);
    // The category form exposes the landing-page content in the WYSIWYG.
    const editor = page.locator('.richtext [contenteditable="true"]').first();
    await editor.waitFor();
    expect((await editor.innerHTML()).length > 50, 'category content loaded into editor');
    const intro = page.getByLabel(/^Intro/).first();
    originalIntro = await intro.inputValue();
    expect(originalIntro.length > 10, 'intro was populated');
    await intro.fill(`${originalIntro} [${marker}]`);
    await page.getByRole('button', { name: /save/i }).click();
    await page.waitForURL(/\/admin\/categories$/);
});

await step('category edit is live on the landing page', async () => {
    await page.context().clearCookies();
    await page.goto(`${BASE}/product/iv-fluids`);
    await page.getByRole('heading', { name: 'IV Fluids', level: 1 }).waitFor();
    expect(await page.getByText(marker, { exact: false }).isVisible(), 'marker intro rendered on landing page');
});

const login = async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
};
const saveHome = async () => Promise.all([
    // Inertia spoofs PUT via POST + _method — match the POST to this endpoint.
    page.waitForResponse((r) => /\/admin\/pages\/home$/.test(r.url()) && r.request().method() === 'POST'),
    page.getByRole('button', { name: /save page content/i }).click(),
]);

await step('admin can toggle a homepage section off and on from Page content', async () => {
    await login();
    await page.goto(`${BASE}/admin/pages/home/edit`);
    const toggle = page.getByLabel('Show testimonials');

    // Turn it OFF (checking first if a previous run left it off), verify the
    // live site, then restore to ON (the seeded default).
    if (!await toggle.isChecked()) { await toggle.check(); await saveHome(); }
    await toggle.uncheck();
    await saveHome();

    await page.context().clearCookies();
    await page.goto(`${BASE}/`);
    await page.waitForLoadState('load');
    expect((await page.getByText('What our clients say').count()) === 0, 'testimonials hidden after toggle off');

    await login();
    await page.goto(`${BASE}/admin/pages/home/edit`);
    await page.getByLabel('Show testimonials').check();
    await saveHome();

    await page.context().clearCookies();
    await page.goto(`${BASE}/`);
    await page.getByText('What our clients say').waitFor();
});

// ── Visitor: the catalogue journey ──────────────────────────────────
await step('home highlights categories, not a product grid', async () => {
    await page.goto(`${BASE}/`);
    const card = page.getByRole('link', { name: /IV Fluids/i }).first();
    await card.waitFor();
    expect((await card.getAttribute('href')) === '/product/iv-fluids', `card href → ${await card.getAttribute('href')}`);
    expect((await page.getByRole('link', { name: /View product/i }).count()) === 0, 'no product cards on home');
    const body = (await page.textContent('body')).toLowerCase();
    expect(!body.includes('request a quote') && !body.includes('get a quote'), 'no quote language on home');
});

await step('category card → landing page with content + link to the full list', async () => {
    await page.getByRole('link', { name: /IV Fluids/i }).first().click();
    await page.waitForURL(/\/product\/iv-fluids$/);
    await page.getByRole('heading', { name: 'IV Fluids', level: 1 }).waitFor();
    // Rich body (WYSIWYG-authored) is rendered, and the way onward is a link.
    expect((await page.locator('.prose-nymak p').count()) >= 2, 'rich category body rendered');
    const listLink = page.getByRole('link', { name: /view all.*products|full product list/i }).first();
    await listLink.waitFor();
    expect((await listLink.getAttribute('href')) === '/product/iv-fluids/products', 'links to the full list');
});

await step('full list shows grouped spec tables with detail links', async () => {
    await page.getByRole('link', { name: /view all.*products|full product list/i }).first().click();
    await page.waitForURL(/\/product\/iv-fluids\/products$/);
    await page.getByRole('heading', { name: /iv fluids.*product list/i, level: 1 }).waitFor();
    expect((await page.locator('table').count()) >= 3, 'grouped tables rendered');
    expect((await page.locator('tbody td').count()) > 20, 'rows rendered');
    // Detail links exist only on categories with detail-enabled products —
    // checked on finished-formulations in the next step.
    // Search narrows the list.
    const search = page.getByLabel(/search this list/i);
    await search.fill('dextrose');
    await until(async () => {
        const cells = await page.locator('tbody td').allTextContents();
        return cells.length > 0 && cells.join(' ').toLowerCase().includes('dextrose');
    }, 'search should narrow the table to dextrose rows');
});

await step('product detail has a contact CTA — no quote flow', async () => {
    await page.goto(`${BASE}/product/finished-formulations/products`);
    // Detail-enabled products appear as linked cards/rows — pick the first.
    const productLink = page.locator('a[href^="/product/finished-formulations/"]').first();
    const href = await productLink.getAttribute('href');
    await productLink.click();
    await page.waitForURL(new RegExp(href.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '$'));
    const body = (await page.textContent('body')).toLowerCase();
    expect(!body.includes('quote'), 'no quote language on detail page');
    const cta = page.getByRole('link', { name: /contact us about this product/i });
    await cta.waitFor();
    await cta.click();
    await page.waitForURL(/\/contact\?product=/);
    await until(async () => (await page.locator('#f-product').inputValue()) !== '', 'product pre-selected in enquiry form');
});

await step('old and trailing-slash URLs 301 to the canonical paths', async () => {
    const checks = [
        ['/products/iv-fluids', '/product/iv-fluids'],
        ['/products/finished-formulations/alumak-20-120-tablets-liberia', '/product/finished-formulations/alumak-20-120-tablets-liberia'],
        ['/product/iv-fluids/', '/product/iv-fluids'],
        ['/about-us/', '/about'],
        ['/contact-us/', '/contact'],
        ['/iv-fluid/', '/product/iv-fluids'],
    ];
    for (const [from, to] of checks) {
        const res = await page.request.get(`${BASE}${from}`, { maxRedirects: 0 });
        expect(res.status() === 301, `${from} → expected 301, got ${res.status()}`);
        const loc = new URL(res.headers().location, BASE).pathname;
        expect(loc === to, `${from} → ${loc}, expected ${to}`);
    }
});

await step('mobile: the journey works on a phone-width viewport', async () => {
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(`${BASE}/`);
    await page.getByRole('link', { name: /IV Fluids/i }).first().click();
    await page.waitForURL(/\/product\/iv-fluids$/);
    await page.getByRole('link', { name: /view all.*products|full product list/i }).first().click();
    await page.waitForURL(/\/product\/iv-fluids\/products$/);
    expect((await page.locator('table').count()) >= 3, 'tables render on mobile (scrollable region)');
});

// ── Restore the category intro ──────────────────────────────────────
await step('restore the category intro', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
    await page.goto(`${BASE}/admin/categories/iv-fluids/edit`);
    await page.getByLabel(/^Intro/).first().waitFor();
    // Strip this run's marker AND any left over from aborted previous runs.
    const current = await page.getByLabel(/^Intro/).first().inputValue();
    await page.getByLabel(/^Intro/).first().fill(current.replace(/\s*\[UAT-[^\]]*\]/g, '') || (originalIntro ?? ''));
    await page.getByRole('button', { name: /save/i }).click();
    await page.waitForURL(/\/admin\/categories$/);
});

await step('no uncaught browser errors', async () => {
    // Local dev with the Vite HMR server bypasses Inertia SSR, so React's
    // hydrateRoot sees an empty #app and logs a hydration mismatch on every
    // page. Dev-environment artifact, not an app defect — ignore only that.
    const real = errors.filter((e) => !e.startsWith('Hydration failed'));
    expect(real.length === 0, `page errors: ${real.join(' | ')}`);
});

await browser.close();
const failed = results.filter((r) => r[0] === 'FAIL');
console.log(`\n${results.length - failed.length}/${results.length} passed`);
process.exit(failed.length ? 1 : 0);
