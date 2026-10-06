/**
 * Real-browser UAT for the Global Presence map + admin WYSIWYG.
 *
 *   node tests/Browser/global-presence-map.mjs
 *
 * Requires the app on BASE_URL (default http://localhost:8000) with the
 * seeded admin user. Drives Chromium exactly like an operator would:
 * 1. Admin logs in, creates a brand-new market (fresh data per run), types
 *    rich content in the editor, saves.
 * 2. Visitor opens /global-presence, clicks the country on the map and sees
 *    that content; keyboard + list + deep-link paths are checked too.
 * 3. Admin deletes the market again so the live catalogue is left untouched.
 */
import { chromium } from 'playwright';

const BASE = process.env.BASE_URL ?? 'http://localhost:8000';
const EMAIL = process.env.NYMAK_ADMIN_EMAIL ?? 'admin@nymakpharma.com';
const PASSWORD = process.env.NYMAK_ADMIN_PASSWORD;
if (!PASSWORD) throw new Error('Set NYMAK_ADMIN_PASSWORD');

const stamp = Date.now().toString(36);
const marker = `UAT-${stamp}`;
// Fresh market per run. Tanzania is seeded nowhere and is large enough to click.
const NAME = `Tanzania ${marker}`;
const SLUG = `tanzania-${stamp}`;
const ISO = 'TZ';
const results = [];
const step = async (name, fn) => {
    try { await fn(); results.push(['PASS', name]); console.log('PASS', name); }
    catch (e) { results.push(['FAIL', name, e.message]); console.log('FAIL', name, '\n   ', e.message.split('\n')[0]); }
};
const expect = (cond, msg) => { if (!cond) throw new Error(msg); };

// Real Chrome (not the bundled headless shell) — what users actually run.
const browser = await chromium.launch({ channel: process.env.BROWSER_CHANNEL ?? 'chrome', headless: !process.env.HEADED });
// reducedMotion keeps the globe's auto-rotation/fly animations off so
// hover/focus actionability checks see a still, deterministic target —
// the same experience users with prefers-reduced-motion get.
const page = await browser.newPage({ viewport: { width: 1360, height: 900 }, reducedMotion: 'reduce' });
const errors = [];
page.on('pageerror', (e) => errors.push(e.message));

// ── Admin: author rich content via the WYSIWYG ──────────────────────
await step('admin can log in', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
});

await step('new-market form shows the country picker and rich-text editor', async () => {
    await page.goto(`${BASE}/admin/markets/create`);
    await page.getByLabel('Country / market').fill(NAME);
    await page.getByLabel('URL slug').fill(SLUG);
    await page.getByLabel('Country on map').selectOption(ISO);
    await page.getByLabel('Region').fill('East Africa');
    await page.locator('.richtext [contenteditable="true"]').waitFor();
    expect(await page.getByRole('toolbar', { name: 'Formatting' }).isVisible(), 'toolbar visible');
});

await step('admin types formatted content and saves', async () => {
    const editor = page.locator('.richtext [contenteditable="true"]');
    await editor.click();
    await page.keyboard.press(process.platform === 'darwin' ? 'Meta+A' : 'Control+A');
    await page.keyboard.press('Backspace');
    await page.getByRole('button', { name: 'Subheading' }).click();
    await page.keyboard.type(`What we do here ${marker}`);
    await page.keyboard.press('Enter');
    await page.keyboard.type('Supplying ');
    await page.getByRole('button', { name: 'Bold' }).click();
    await page.keyboard.type('IV fluids');
    await page.getByRole('button', { name: 'Bold' }).click();
    await page.keyboard.type(' to county hospitals.');
    await page.keyboard.press('Enter');
    await page.getByRole('button', { name: 'Bullet list' }).click();
    await page.keyboard.type('Nairobi distributor');
    await page.keyboard.press('Enter');
    await page.keyboard.type('PPB registrations');

    await page.getByLabel('Short summary').fill(`Tanzania summary ${marker}`);
    await page.getByRole('button', { name: /create market/i }).click();
    await page.waitForURL(/\/admin\/markets$/);
});

await step('saved content round-trips into the editor as HTML', async () => {
    await page.goto(`${BASE}/admin/markets/${SLUG}/edit`);
    const editor = page.locator('.richtext [contenteditable="true"]');
    await editor.waitFor();
    const html = await editor.innerHTML();
    expect(html.includes(`<h3>What we do here ${marker}</h3>`), `expected h3 in editor, got: ${html.slice(0, 200)}`);
    expect(html.includes('<strong>IV fluids</strong>'), 'bold survived round-trip');
    expect(/<ul>[\s\S]*<li>[\s\S]*Nairobi distributor/.test(html), 'bullet list survived round-trip');
});

// ── Visitor: find it on the map ─────────────────────────────────────
await step('visitor sees the map with clickable countries and an empty-state panel', async () => {
    await page.context().clearCookies();
    await page.goto(`${BASE}/global-presence`);
    await page.locator('.world-map svg').waitFor();
    const countries = page.locator('.map-active path[role="button"]');
    expect((await countries.count()) >= 10, `expected ≥10 clickable countries, got ${await countries.count()}`);
    expect(await page.locator('.globe-arc').count() >= 10, 'supply-route arcs from Mundra rendered');
    expect(await page.locator('.globe-hq').isVisible(), 'Mundra HQ marker shown');
    expect(await page.getByText('Spin the globe — pick a country').isVisible(), 'placeholder panel shown');
});

const target = () => page.getByRole('button', { name: new RegExp(`^${NAME} — view`) });

await step('hovering a country shows a summary card', async () => {
    await target().hover();
    const tip = page.getByRole('tooltip');
    await tip.waitFor();
    expect((await tip.textContent()).includes(`Tanzania summary ${marker}`), 'tooltip shows admin summary');
});

await step('clicking the country highlights it and shows the admin-authored content', async () => {
    await target().click();
    expect(await target().getAttribute('aria-pressed') === 'true', 'country is pressed');
    expect(await target().getAttribute('data-selected') === 'true', 'country is gold-highlighted');
    const panel = page.locator('.explorer-panel');
    await panel.getByRole('heading', { name: NAME, level: 3 }).waitFor();
    expect(await panel.getByRole('heading', { name: `What we do here ${marker}` }).isVisible(), 'rich h3 rendered');
    expect(await panel.locator('strong', { hasText: 'IV fluids' }).isVisible(), 'bold rendered');
    expect(await panel.locator('li', { hasText: 'PPB registrations' }).isVisible(), 'list rendered');
    expect(page.url().endsWith(`#${SLUG}`), `URL hash updated, got ${page.url()}`);
});

await step('key markets show their supplied products and local office', async () => {
    await page.getByRole('button', { name: /^Sierra Leone — view/ }).click();
    const panel = page.locator('.explorer-panel');
    await panel.getByRole('heading', { name: 'Sierra Leone', level: 3 }).waitFor();
    expect(await panel.getByText('Key market').isVisible(), 'key market badge');
    expect((await panel.locator('a[href^="/product/"]').count()) > 0, 'product chips link to product pages');
    expect(await panel.locator('address').isVisible(), 'local office block');
});

await step('the region list mirrors and drives the same selection', async () => {
    const nigeria = page.locator('.map-list-btn', { hasText: 'Nigeria' });
    await nigeria.click();
    expect(await nigeria.getAttribute('aria-pressed') === 'true', 'list button pressed');
    expect(await page.getByRole('button', { name: /^Nigeria — view/ }).getAttribute('aria-pressed') === 'true', 'map path pressed');
    await page.locator('.explorer-panel').getByRole('heading', { name: 'Nigeria', level: 3 }).waitFor();
});

await step('pinned region (no ISO code) is selectable — list pick spins the globe to it', async () => {
    // South Pacific is on the far side at the opening view — a real user picks
    // it from the list, which rotates the globe until its pin appears.
    await page.locator('.map-list-btn', { hasText: 'South Pacific Islands' }).click();
    const pin = page.getByRole('button', { name: /^South Pacific Islands — view/ });
    await pin.waitFor();
    await page.locator('.explorer-panel').getByRole('heading', { name: 'South Pacific Islands', level: 3 }).waitFor();
});

await step('keyboard: Tab to a country, Enter selects, close button clears', async () => {
    await page.getByRole('button', { name: 'Clear selection' }).click();
    await page.getByText('Spin the globe — pick a country').waitFor();
    await page.getByRole('button', { name: /^Ghana — view/ }).focus();
    await page.keyboard.press('Enter');
    await page.locator('.explorer-panel').getByRole('heading', { name: 'Ghana', level: 3 }).waitFor();
});

await step('deep link opens the market directly', async () => {
    await page.goto(`${BASE}/global-presence#liberia`);
    await page.locator('.explorer-panel').getByRole('heading', { name: 'Liberia', level: 3 }).waitFor();
});

await step('mobile: selecting scrolls the panel into view', async () => {
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(`${BASE}/global-presence`);
    await page.locator('.world-map svg').waitFor();
    await page.getByRole('button', { name: /^Nigeria — view/ }).click({ force: true });
    await page.locator('.explorer-panel').getByRole('heading', { name: 'Nigeria', level: 3 }).waitFor();
    await page.waitForTimeout(700);
    const box = await page.locator('.explorer-panel').boundingBox();
    expect(box && box.y >= 0 && box.y < 400, `panel should be scrolled into view, top=${box?.y}`);
});

// ── Admin: clean up the run's market ────────────────────────────────
await step('admin deletes the market and it leaves the map', async () => {
    await page.setViewportSize({ width: 1360, height: 900 });
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
    await page.goto(`${BASE}/admin/markets?q=${encodeURIComponent(marker)}`);
    const row = page.locator('tr', { hasText: NAME });
    await row.waitFor();
    await row.getByRole('button', { name: 'Delete' }).click();
    await page.getByRole('dialog', { name: 'Confirm deletion' }).getByRole('button', { name: /delete/i }).click();
    await row.waitFor({ state: 'detached' });

    await page.context().clearCookies();
    await page.goto(`${BASE}/global-presence`);
    await page.locator('.world-map svg').waitFor();
    expect((await target().count()) === 0, 'deleted market is gone from the map');
});

await step('no uncaught browser errors', async () => {
    // Local dev with the Vite HMR server bypasses Inertia SSR, so React's
    // hydrateRoot sees an empty #app and logs a hydration mismatch on every
    // page. That is a dev-environment artifact (SSR is on in production), not
    // an app defect — ignore only that message.
    const real = errors.filter((e) => !e.startsWith('Hydration failed'));
    expect(real.length === 0, `page errors: ${real.join(' | ')}`);
});

await browser.close();
const failed = results.filter((r) => r[0] === 'FAIL');
console.log(`\n${results.length - failed.length}/${results.length} passed`);
process.exit(failed.length ? 1 : 0);
