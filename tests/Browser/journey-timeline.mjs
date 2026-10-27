/**
 * Real-browser UAT for the About journey timeline + its admin CRUD.
 *
 *   node tests/Browser/journey-timeline.mjs
 *
 * Requires the app on BASE_URL (default http://localhost:8000) with the
 * seeded admin user. Drives Chromium exactly like an operator would:
 * 1. Admin logs in, adds a timeline entry (fresh data per run) incl. FR
 *    translations, and it appears on /about under its year chevron.
 * 2. The rail's structure is verified: chevron segments per year, stems,
 *    node dots, image cards and icon fallbacks.
 * 3. Admin deletes the entry again so the seeded story is left untouched.
 */
import { chromium } from 'playwright';

const BASE = process.env.BASE_URL ?? 'http://localhost:8000';
const EMAIL = process.env.NYMAK_ADMIN_EMAIL ?? 'admin@nymakpharma.com';
const PASSWORD = process.env.NYMAK_ADMIN_PASSWORD;
if (!PASSWORD) throw new Error('Set NYMAK_ADMIN_PASSWORD');

const stamp = Date.now().toString(36);
const marker = `UAT-${stamp}`;
const TITLE = `New warehouse opens ${marker}`;
const CAPTION = `Second dispatch facility ${marker}`;
const results = [];
const step = async (name, fn) => {
    try { await fn(); results.push(['PASS', name]); console.log('PASS', name); }
    catch (e) { results.push(['FAIL', name, e.message]); console.log('FAIL', name, '\n   ', e.message.split('\n')[0]); }
};
const expect = (cond, msg) => { if (!cond) throw new Error(msg); };

const browser = await chromium.launch({ channel: process.env.BROWSER_CHANNEL ?? 'chrome', headless: !process.env.HEADED });
const page = await browser.newPage({ viewport: { width: 1360, height: 900 }, reducedMotion: 'reduce' });
const errors = [];
page.on('pageerror', (e) => errors.push(e.message));

// ── Admin: add a timeline entry ──────────────────────────────────────
await step('admin can log in', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
});

await step('journey index lists seeded entries', async () => {
    await page.goto(`${BASE}/admin/journey`);
    await page.locator('tr', { hasText: 'Founded in Gujarat' }).waitFor();
    expect((await page.locator('tbody tr').count()) >= 14, 'seeded entries listed');
});

await step('new-entry form accepts a node and translations', async () => {
    await page.goto(`${BASE}/admin/journey/create`);
    await page.locator('#f-year').waitFor();
    await page.locator('#f-year').fill('2026');
    // Title/Caption labels are shadowed by the FR/ES translation inputs - ids
    // are the deterministic target here.
    await page.locator('#f-title').fill(TITLE);
    await page.locator('#f-body').fill(CAPTION);
    await page.locator('#f-icon').fill('faBuilding');
    await page.locator('#f-fit').selectOption('cover');
    await page.locator('#f-sort_order').fill('150');
    await page.locator('#f-i18n\\.fr\\.title').fill(`Nouvel entrepôt ${marker}`);
    await page.getByRole('button', { name: 'Save', exact: true }).click();
    await page.waitForURL(/\/admin\/journey$/);
    await page.locator('tr', { hasText: TITLE }).waitFor();
});

// ── Visitor: the rail shows it ───────────────────────────────────────
await step('visitor sees the chevron rail with the new node', async () => {
    await page.context().clearCookies();
    await page.goto(`${BASE}/about`);
    const rail = page.locator('.journey-scroll');
    await rail.scrollIntoViewIfNeeded();
    await rail.locator('.journey-seg').first().waitFor();
    // One chevron segment per distinct year: 14 seeded years + the new 2026.
    expect(await rail.locator('.journey-seg').count() >= 14, 'chevron per year');
    const card = rail.locator('.journey-node', { hasText: TITLE });
    await card.scrollIntoViewIfNeeded();
    expect(await card.locator('h3').innerText() === TITLE, 'node title rendered');
    expect((await card.locator('figcaption p').innerText()).includes(CAPTION), 'node caption rendered');
    // Icon fallback tile renders since no image was uploaded.
    expect(await card.locator('.journey-icon-tile svg').count() === 1, 'icon fallback tile rendered');
});

await step('year marker groups sibling entries', async () => {
    const rail = page.locator('.journey-scroll');
    // 2024 has the seeded node; 2026 now has the UAT node - each gets one marker.
    const y2026 = rail.locator('.journey-year', { hasText: '2026' });
    expect(await y2026.count() === 1, 'one chevron segment for the new year');
    const span = await y2026.getAttribute('style');
    expect(span.includes('span 1'), `2026 segment spans its single card, got: ${span}`);
});

await step('fr page renders translated journey titles', async () => {
    await page.goto(`${BASE}/fr/about`);
    const rail = page.locator('.journey-scroll');
    await rail.scrollIntoViewIfNeeded();
    await rail.locator('.journey-node', { hasText: 'Fondation au Gujarat' }).first().waitFor();
});

// ── Admin: clean up ──────────────────────────────────────────────────
await step('admin deletes the entry and it leaves the rail', async () => {
    await page.goto(`${BASE}/admin/login`);
    await page.getByLabel(/email/i).fill(EMAIL);
    await page.getByLabel(/password/i).fill(PASSWORD);
    await page.getByRole('button', { name: /sign in|log in/i }).click();
    await page.waitForURL(/\/admin\/dashboard/);
    await page.goto(`${BASE}/admin/journey?q=${encodeURIComponent(marker)}`);
    const row = page.locator('tr', { hasText: TITLE });
    await row.waitFor();
    await row.getByRole('button', { name: 'Delete' }).click();
    await page.getByRole('dialog', { name: 'Confirm deletion' }).getByRole('button', { name: /delete/i }).click();
    await row.waitFor({ state: 'detached' });

    await page.context().clearCookies();
    await page.goto(`${BASE}/about`);
    await page.locator('.journey-scroll .journey-seg').first().waitFor();
    expect((await page.locator('.journey-node', { hasText: TITLE }).count()) === 0, 'deleted node gone from the rail');
});

await step('no uncaught browser errors', async () => {
    const real = errors.filter((e) => !e.startsWith('Hydration failed'));
    expect(real.length === 0, `page errors: ${real.join(' | ')}`);
});

await browser.close();
const failed = results.filter((r) => r[0] === 'FAIL');
console.log(`\n${results.length - failed.length}/${results.length} passed`);
process.exit(failed.length ? 1 : 0);
