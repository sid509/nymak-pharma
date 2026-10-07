# UAT Issues

Issues discovered while driving real Chrome (Playwright) through user
workflows — not found by HTTP/feature tests. Each entry records severity, the
affected workflow, root cause, the fix, and the regression guard.

Journeys: `tests/Browser/global-presence-map.mjs`, `tests/Browser/product-hierarchy.mjs`, `tests/Browser/locale.mjs`.

## Fixed

### UAT-01 — Admin form labels not associated with inputs

- **Severity:** medium (accessibility + blocks every label-based locator)
- **Workflow:** admin edits a record via any `/admin/.../edit` form
- **Found by:** `global-presence-map.mjs` — `getByLabel('Country')` matched nothing
- **Root cause:** `Field.jsx` rendered the `id` on a wrapper `<span>` around the
  label text, not on the input, and no `htmlFor` linked them.
- **Fix:** `id` moved onto the actual control; label uses `htmlFor`.
- **Regression:** all admin UAT steps locate fields via `getByLabel`.

### UAT-02 — Rich-text editor deadlocked on mount

- **Severity:** high (admin could not type into the WYSIWYG)
- **Workflow:** admin opens market/category form containing a richtext field
- **Found by:** `global-presence-map.mjs` — editor never became editable
- **Root cause:** TipTap v3's `useEditorState` snapshot stays `{ editor: null }`
  until the first transaction; gating the render on it prevented the editor
  from ever mounting. Toolbar clicks also stole editor focus.
- **Fix:** gate on `editor` instance only; default toolbar state; `mousedown`
  prevention on toolbar buttons.
- **Regression:** UAT types into the editor and asserts saved HTML.

### UAT-03 — Related products linked under the wrong category → 404

- **Severity:** high (broken public links from a product page)
- **Workflow:** visitor opens a branded product page, clicks a related product
- **Found by:** `product-hierarchy.mjs` — related cards 404'd
- **Root cause:** related URL used the *current* page's category slug, but
  related products are matched cross-category by market/therapeutic group.
  Scoped route bindings then rejected the pair.
- **Fix:** emit `/product/{own-category}/{slug}` with `category` eager-loaded.
- **Regression:** `PagesTest::related_products_link_under_their_own_category`
  GETs every emitted related URL and asserts 200.

### UAT-04 — Homepage section toggle left disabled after a failed run

- **Severity:** test artifact (not a product bug)
- **Workflow:** `product-hierarchy.mjs` toggle step
- **Root cause:** the script assumed the toggle started enabled; an aborted
  run left it off in the dev DB.
- **Fix:** the journey is now state-aware — reads the current toggle, and its
  cleanup step strips leftover `[UAT-*]` markers from any earlier aborted run.

### UAT-05 — Supply-route arcs swallowed country clicks

- **Severity:** high (map clicks land on an invisible arc instead of the market)
- **Workflow:** visitor clicks a market country on the globe
- **Found by:** `global-presence-map.mjs` — `hover`/`click` timed out with
  "`<path class="globe-arc">` subtree intercepts pointer events"
- **Root cause:** `.globe-routes` is painted after the country shapes, so its
  strokes sit on top; SVG hit-testing sent the click to the arc.
- **Fix:** the routes group is `aria-hidden` + `pointer-events: none`
  (render-level, in `WorldMap.jsx`) — decorative layers never take hits.
- **Regression:** `WorldMap.test.jsx` asserts the routes group carries
  `pointer-events:none`; UAT clicks a country whose arc crosses its centre.

### UAT-06 — Deselect left the globe facing the far side (keyboard targets gone)

- **Severity:** medium (keyboard users lost every far-side market button)
- **Workflow:** select a far-side market, clear the selection, tab to a
  country that is now behind the horizon
- **Found by:** `global-presence-map.mjs` — `focus()` on Ghana timed out
  because its path wasn't rendered after clearing South Pacific
- **Root cause:** clearing the selection left the view wherever the fly-to
  had left it; markets behind the horizon have no focusable element.
- **Fix:** deselect flies the globe back to the hub view (India-centred).
  Also hardening while here: auto-rotation now pauses whenever the pointer is
  over the globe or focus is inside it — a still target for both pointer and
  keyboard users.
- **Regression:** UAT keyboard step (Tab → Enter → Clear) passes under
  `reducedMotion: 'reduce'`, the same experience reduced-motion users get.

### UAT-07 — `route()` dropped the locale on redirects (FR contact form landed back on EN)

- **Severity:** high (every locale-prefixed redirect lost its prefix)
- **Workflow:** POST `/fr/contact` → `redirect()->route('contact')` emitted
  `/contact`, not `/fr/contact`
- **Found by:** `LocaleTest` — the assertRedirect caught `/contact`
- **Root cause:** route `nameList` keeps the *first* registration (`??=`), so
  named routes resolved to the bare English URI `{no locale}` and
  `URL::defaults('locale')` never applied.
- **Fix:** the `{locale?}` group now registers first; bare English routes
  second. Named routes carry `{locale?}` and generate `/fr/…` under a French
  request, `/…` under English.
- **Regression:** `LocaleTest` asserts `/fr/contact` and `/es/contact`
  redirects; legacy `/fr/about-us` → `/fr/about` is covered too.

### UAT-08 — `locale` route param leaked into controller arguments (500 on every bound FR page)

- **Severity:** critical (`/fr/product/{cat}/{slug}`, `/fr/blog/{post}`,
  `/fr/team/{member}` all TypeError'd)
- **Workflow:** open any model-bound public page under `/fr` or `/es`
- **Found by:** `LocaleTest::translated_model_content_renders…` — 500 instead
  of 200
- **Root cause:** `{locale?}` prefix params are passed positionally to
  controller methods — `show(ProductCategory $c, Product $p)` received
  `('fr', $category, $product)`.
- **Fix:** `SetLocale` calls `Route::forgetParameter('locale')` after reading
  it, so implicit bindings stay positional.
- **Regression:** LocaleTest GETs a product detail page under `/fr` and `/es`.

### UAT-09 — `i18n` JSON column read raw → translations never resolved; save crashed

- **Severity:** high (no translated content could ever render; admin save 500'd)
- **Workflow:** set a French product name, view `/fr/product/…`
- **Found by:** `LocaleTest` — `Cannot access offset of type string on string`
- **Root cause:** `getAttributeFromArray('i18n')` returns the raw JSON string
  (casts apply on access, not storage) — `data_get` on it always missed, and
  `setTranslations` wrote to a string offset.
- **Fix:** `i18nArray()` decodes the raw attribute before every read/write.
- **Regression:** LocaleTest saves FR/ES names via `setTranslations` and
  asserts they render (plus English fallback when a locale field is blank).

### UAT-10 — Global-presence page crashed client-side (`t is not defined`)

- **Severity:** critical (the whole `/global-presence` page was dead in the
  browser — white panel, no map interaction)
- **Workflow:** visitor opens `/global-presence`
- **Found by:** `global-presence-map.mjs` — `page errors: t is not defined`;
  every interactive step timed out
- **Root cause:** the i18n sweep wrapped chrome strings in `t()` inside
  `MarketPanel`/`EmptyPanel` — module-level components that never called
  `useT()`, so `t` was unbound.
- **Fix:** `useT()` inside each subcomponent; also translated the two raw
  strings missed first pass ('Supplied to {name} — {n}',
  '{n} markets across the globe').
- **Regression:** the map journey's "no uncaught browser errors" step plus
  locale.mjs's per-page `pageerror` listener.

## UAT-11 — Translated related names silent on FR/ES product pages
- **Severity:** medium (translations stored but never rendered)
- **Workflow:** visitor opens `/fr/product/{cat}/products` or a detail page
- **Found by:** manual verification after seeding — category names stayed
  English despite `i18n.fr.name` being set
- **Root cause:** `with('category:id,name,slug')` column lists omitted
  `i18n`; `HasTranslations` can't resolve a locale the model never loaded.
- **Fix:** added `i18n` to the four eager-load selects across Home,
  Inside, Market and Product controllers.
- **Regression:** verified via Inertia props (`Comprimés` under /fr,
  `IV Fluids` under /) + real-browser screenshots.
