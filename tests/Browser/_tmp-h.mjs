import { chromium } from 'playwright';
const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1440, height: 950 } });
await page.goto('http://localhost:8000/', { waitUntil: 'networkidle' });
const y = await page.evaluate(() => {
  const h = [...document.querySelectorAll('h2')].find(x => x.textContent.includes('product segments'));
  return h ? h.getBoundingClientRect().top + scrollY : null;
});
console.log('heading y:', y);
await page.evaluate((v) => window.scrollTo(0, v), y - 40);
await page.waitForTimeout(1000);
await page.screenshot({ path: '/tmp/seg-a.png' });
// hover segment 3 to see card height change
await page.locator('[data-segment]').nth(2).hover();
await page.waitForTimeout(500);
await page.screenshot({ path: '/tmp/seg-b.png' });
await page.locator('[data-segment]').nth(4).hover();
await page.waitForTimeout(500);
await page.screenshot({ path: '/tmp/seg-c.png' });
await browser.close();
