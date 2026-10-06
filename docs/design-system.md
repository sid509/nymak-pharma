# Design System — FROZEN

This documents the **approved redesign as implemented** in `Sources/`
(Laravel 13 + Inertia React + Tailwind CSS 4). It is the design source of truth —
do not restyle or introduce new tokens; extend using what exists.

## Technology

- Tailwind CSS 4 (`@theme` tokens in `resources/css/app.css`)
- React 19 + Inertia (SSR), Lucide icons (`lucide-react`)
- Font: **Manrope Variable** (`@fontsource-variable/manrope`), system sans fallback

## Colour palette (frozen)

Defined in `resources/css/app.css` `@theme` — no other brand colours exist.

### Brand — deep clinical teal (primary)
| Token | Hex | Use |
|---|---|---|
| `brand-50` | `#EEFCFB` | tint backgrounds, hover fills |
| `brand-100` | `#D5F6F4` | light fills |
| `brand-200` | `#B0ECE9` | selection bg |
| `brand-300` | `#7EDEDA` | footer headings, accents on dark |
| `brand-400` | `#45C6C2` | icon accents on dark |
| `brand-500` | `#28ABA8` | focus rings |
| `brand-600` | `#1E8D8B` | gradient mid |
| `brand-700` | `#0E7A72` | **primary buttons, links, eyebrows** |
| `brand-800` | `#12605C` | button hover |
| `brand-900` | `#134F4D` | deep fills |
| `brand-950` | `#06302F` | darkest brand surface |

### Ink — slate/neutral scale (text & surfaces)
| Token | Hex | Use |
|---|---|---|
| `ink-50` | `#F4F7F8` | subtle section bg |
| `ink-100` | `#E4EAEC` | borders |
| `ink-200` | `#C7D3D7` | input borders |
| `ink-300` | `#A2B4BB` | muted text on dark |
| `ink-400` | `#748F99` | placeholders, footer text |
| `ink-500` | `#58737F` | breadcrumb text |
| `ink-600` | `#4B606B` | secondary text |
| `ink-700` | `#3F515A` | body/nav text |
| `ink-800` | `#2C3F47` | dark surfaces (footer cards) |
| `ink-900` | `#16293A` | headings |
| `ink-950` | `#0A1C29` | utility bar, footer, dark bands |

### Gold (accent — sparing)
`gold-400 #E8B95C` · `gold-500 #D9A03F` · `gold-600 #B97F26` — timeline/journey accents only.

## Typography

- Family: `Manrope Variable` (single family, weight-driven hierarchy)
- Page H1 (`PageHero`): `text-4xl sm:text-5xl font-extrabold tracking-tight text-ink-950`
- Section H2 (`SectionHeading`): `text-3xl sm:text-4xl font-extrabold tracking-tight text-ink-900`
- Card H3: `text-base/lg font-bold text-ink-900`
- Eyebrow: `text-xs font-bold uppercase tracking-[0.2em] text-brand-700`
- Body: `text-sm/base text-ink-700 leading-relaxed`; lead paragraphs `text-lg text-ink-600`
- Long-form (`prose-nymak`): h2 `2xl extrabold`, h3 `xl bold`, `text-ink-700` paragraphs — blog/legal pages

## Components & patterns

- **Container:** `max-w-7xl px-4 sm:px-6` everywhere
- **Buttons (`ButtonLink`):** `rounded-lg px-5 py-3 text-sm font-bold`; variants — `primary` (brand-700→800), `outline`, `light`, `ghost`. Primary/outline/light get `btn-cta` (sheen sweep + arrow travel on hover)
- **Header:** dark utility bar (`bg-ink-950`) + sticky white nav (`bg-white/95 backdrop-blur`), shadow on scroll; lg breakpoint for desktop menu; mobile hamburger panel
- **PageHero:** breadcrumbs + eyebrow + H1 + lead on `bg-gradient-to-b from-brand-50/60 to-white`
- **Cards:** `rounded-xl/2xl border border-ink-100 bg-white shadow-card`; hover lifts via `shadow-card-hover` (`--shadow-card`/`--shadow-card-hover` tokens)
- **Spec tables (`spec-table`):** `bg-ink-50` header row, `border-ink-100` row separators — product tables
- **Stat blocks:** big numeral `text-4xl/5xl font-extrabold` + uppercase `text-brand-200` label on dark bands
- **Forms (`EnquiryForm`):** `rounded-lg border-ink-200` inputs, `focus:border-brand-500 focus:ring-2 focus:ring-brand-100`; labels `text-xs font-bold uppercase tracking-wider`
- **Footer:** `bg-ink-950 text-ink-200`, 4-column grid (brand/company/products/NAP)

## Motion system (frozen)

- Scroll reveals: `.reveal` (fade+rise 18px) & `.reveal-clip` via IntersectionObserver — compositor-only transforms
- Home hero: one-time staged `.enter` cascade (4 children)
- `btn-cta` sheen + arrow micro-interaction
- Inside Nymak: gradient `story-rail` spine + `story-node` year rings; `.explorer-panel` swap animation
- Client logo `.marquee` (36s loop, pauses on hover/focus)
- `prefers-reduced-motion` disables all animation — a11y respected globally

## Responsive behaviour

- Mobile-first; nav collapses below `lg`; tables scroll horizontally (`overflow-x-auto`); tap targets ≥ ~40px
- Stats/marquee/grids collapse to single column on small screens

## Assets

- All imagery converted to WebP (`scripts/convert-images.php`, committed under `public/images/`)
- Sources: client-supplied `Resources/` (drone shots, pack shots, certification scans, client logos)
- `fetchpriority="high"` on hero images; lazy-load below the fold; descriptive alt text required

## What is NOT allowed without re-approval

New colours, fonts, button styles, radius scale, hero/section layout patterns,
or animation styles. Reuse tokens above.
