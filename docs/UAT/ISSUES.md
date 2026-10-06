# UAT Issues

Issues discovered while driving real Chrome (Playwright) through user
workflows — not found by HTTP/feature tests. Each entry records severity, the
affected workflow, root cause, the fix, and the regression guard.

Journeys: `tests/Browser/global-presence-map.mjs`, `tests/Browser/product-hierarchy.mjs`.

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
