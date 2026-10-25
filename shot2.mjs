import { chromium } from 'playwright';
const pages = [
  ['/', 'home'], ['/about', 'about'], ['/manufacturing', 'manufacturing'],
  ['/quality-certifications', 'quality'], ['/global-presence', 'global'],
  ['/team', 'team'], ['/products', 'products'], ['/inside-nymak', 'inside'],
];
const b = await chromium.launch();
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
for (const [url, name] of pages) {
  await p.goto(`http://localhost:8000${url}`, { waitUntil: 'networkidle' });
  // scroll through slowly to trigger IntersectionObserver reveals
  await p.evaluate(async () => {
    await new Promise((res) => {
      let y = 0;
      const step = () => { y += 600; window.scrollTo(0, y); if (y < document.body.scrollHeight) setTimeout(step, 80); else res(); };
      step();
    });
  });
  await p.waitForTimeout(1500);
  await p.screenshot({ path: `/tmp/ny2-${name}.png`, fullPage: true });
  console.log(name, 'done');
}
await b.close();
