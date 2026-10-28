import { geoCentroid, geoNaturalEarth1, geoPath } from 'd3-geo';
import { useMemo, useState } from 'react';
import { feature, merge } from 'topojson-client';
import world from 'world-atlas/countries-110m.json';
import { numericId } from '../data/countries';

/**
 * Pinboard map - the global-presence wall translated to the web. A flat world
 * map cut from warm pin-board sheet, with a matte metal push pin on every
 * market Nymak serves. Pins come in three finishes matching the office-wall
 * legend: gold for our own presence, blue for ethical markets, green for
 * partner markets. Pure SVG + d3-geo: renders on the server, no tiles or API
 * keys. Pins (and their countries) select a market; the map itself stays
 * still like the wall it is drawn from.
 */

const W = 1000;
const H = 560;

// Antarctica (atlas id 010) is off the board - the wall map stops at the
// southern tips, and the slab would only burn a strip of empty board.
const features = feature(world, world.objects.countries).features
    .filter((f) => f.id !== '010');
const byId = new Map(features.map((f) => [f.id, f]));
// Continents as single shapes, no country borders - the pinboard wall shows
// quiet landmasses, not a political map. Borders stay only under the pins.
const land = merge(world, world.objects.countries.geometries.filter((g) => g.id !== '010'));

/** Resolve each market to a country id and a geo [lng, lat] point. */
export function placeMarkets(markets) {
    return markets.map((m) => {
        const id = numericId(m.iso_code);
        const f = id ? byId.get(id) : null;
        const point = m.latitude != null && m.longitude != null
            ? [Number(m.longitude), Number(m.latitude)]
            : f ? geoCentroid(f) : null;
        return { ...m, countryId: f?.id ?? null, point };
    });
}

const PIN_TYPES = ['presence', 'ethical', 'partner'];

export default function WorldMap({ markets, offices = [], selected, onSelect, className = '', officeAnchor = 'offices' }) {
    const [hover, setHover] = useState(null); // { slug, x, y }

    const placed = useMemo(() => placeMarkets(markets), [markets]);
    const byCountry = useMemo(() => new Map(placed.filter((m) => m.countryId).map((m) => [m.countryId, m])), [placed]);

    // Offices are gold "presence" pins too, but only where no market pin
    // already marks that office's country (Sierra Leone / Liberia market pins
    // are pinned at their office cities). India and the UK get their pins here.
    const officePins = useMemo(() => {
        const pinnedIsos = new Set(placed.map((m) => m.iso_code));
        return offices
            .filter((o) => o.latitude != null && o.longitude != null && !pinnedIsos.has(o.country_code))
            .map((o, i) => ({ ...o, slug: `office-${i}`, point: [Number(o.longitude), Number(o.latitude)] }));
    }, [offices, placed]);

    const hovered = hover
        ? placed.find((m) => m.slug === hover.slug) ?? officePins.find((o) => o.slug === hover.slug)
        : null;
    const active = placed.find((m) => m.slug === selected) ?? null;

    const projection = useMemo(() => geoNaturalEarth1()
        .fitExtent([[26, 18], [W - 26, H - 26]], { type: 'FeatureCollection', features }), []);
    const path = useMemo(() => geoPath(projection), [projection]);

    const landPath = useMemo(() => path(land), [path]);
    const countries = useMemo(() => features
        .map((f) => ({ id: f.id, name: f.properties.name, d: path(f) }))
        .filter((c) => c.d), [path]);

    const pins = placed.filter((m) => m.point).map((m) => ({ m, xy: projection(m.point) }));
    const offPins = officePins.filter((o) => o.point).map((o) => ({ o, xy: projection(o.point) }));

    // Office pins are not markets - clicking brings the offices list into view.
    const goToOffices = () => document.getElementById(officeAnchor)?.scrollIntoView({ behavior: 'smooth', block: 'start' });

    const tip = (m) => (e) => {
        const box = e.currentTarget.ownerSVGElement.getBoundingClientRect();
        setHover({ slug: m.slug, x: ((e.clientX - box.left) / box.width) * 100, y: ((e.clientY - box.top) / box.height) * 100 });
    };
    const tipAt = (m, xy) => setHover({ slug: m.slug, x: (xy[0] / W) * 100, y: (xy[1] / H) * 100 });
    const key = (m) => (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); onSelect(m.slug); }
    };
    const toggle = (m) => () => onSelect(m.slug === selected ? null : m.slug);
    const pinClass = (m) => PIN_TYPES.includes(m.pin_type) ? m.pin_type : 'partner';

    return (
        <div className={`world-map relative ${className}`} onMouseLeave={() => setHover(null)}>
            <svg viewBox={`0 0 ${W} ${H}`} className="block h-auto w-full pinboard-svg"
                 role="group" aria-label="World map with a pin on every market Nymak Pharma serves">
                <defs>
                    {/* Pinboard sheet - warm acoustic board, faintly lit from above */}
                    <linearGradient id="board-fill" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stopColor="#d7c6a2" />
                        <stop offset="55%" stopColor="#cdb996" />
                        <stop offset="100%" stopColor="#bfa87e" />
                    </linearGradient>
                    {/* Land - the cut sheet, a touch deeper than the board */}
                    <linearGradient id="land-fill" x1="0" y1="0" x2="0.25" y2="1">
                        <stop offset="0%" stopColor="#b7a17a" />
                        <stop offset="100%" stopColor="#a28c62" />
                    </linearGradient>
                    {/* Paper fibre grain - deterministic noise so SSR and client agree */}
                    <filter id="board-grain" x="0" y="0" width="100%" height="100%">
                        <feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" stitchTiles="stitch" result="n" />
                        <feColorMatrix in="n" type="matrix" values="0 0 0 0 0.32  0 0 0 0 0.25  0 0 0 0 0.13  0 0 0 0.06 0" />
                    </filter>
                    {/* Matte metal pin heads - light catching the top-left of each sphere */}
                    <radialGradient id="pin-presence" cx="0.35" cy="0.3" r="0.9">
                        <stop offset="0%" stopColor="#eed9a0" />
                        <stop offset="45%" stopColor="#c9a24f" />
                        <stop offset="100%" stopColor="#836626" />
                    </radialGradient>
                    <radialGradient id="pin-ethical" cx="0.35" cy="0.3" r="0.9">
                        <stop offset="0%" stopColor="#a8c4da" />
                        <stop offset="45%" stopColor="#4f7ba0" />
                        <stop offset="100%" stopColor="#2c4d68" />
                    </radialGradient>
                    <radialGradient id="pin-partner" cx="0.35" cy="0.3" r="0.9">
                        <stop offset="0%" stopColor="#aacba4" />
                        <stop offset="45%" stopColor="#5d8f5f" />
                        <stop offset="100%" stopColor="#38593c" />
                    </radialGradient>
                    <radialGradient id="pin-halo" r="0.5">
                        <stop offset="0%" stopColor="#fff" stopOpacity="0.85" />
                        <stop offset="100%" stopColor="#fff" stopOpacity="0" />
                    </radialGradient>
                </defs>

                {/* The board */}
                <rect x="8" y="8" width={W - 16} height={H - 16} rx="14" fill="url(#board-fill)" />
                <rect x="8" y="8" width={W - 16} height={H - 16} rx="14" className="pinboard-edge" />

                {/* Land - one quiet silhouette pressed on the board, the way the
                    wall piece reads. Market countries keep an invisible shape
                    under the pointer: a faint tint on hover, nothing at rest. */}
                <path className="pin-land-shape" d={landPath} aria-hidden />
                <g className="pin-land-active">
                    {countries.filter((c) => byCountry.has(c.id)).map((c) => {
                        const m = byCountry.get(c.id);
                        return (
                            <path key={c.id} d={c.d} data-selected={m.slug === selected ? 'true' : undefined}
                                  onClick={toggle(m)} onMouseEnter={tip(m)} onMouseMove={tip(m)}
                                  onMouseLeave={() => setHover(null)}>
                                <title>{m.name}</title>
                            </path>
                        );
                    })}
                </g>

                {/* Grain over board + land, under the pins */}
                <rect x="8" y="8" width={W - 16} height={H - 16} rx="14" filter="url(#board-grain)"
                      pointerEvents="none" aria-hidden />

                {/* Office pins - our presence locations that have no market of
                    their own (Mundra, Ahmedabad, London). Gold, like the wall. */}
                {offPins.map(({ o, xy }) => {
                    const [x, y] = xy;
                    return (
                        <g key={o.slug} transform={`translate(${x.toFixed(1)} ${y.toFixed(1)})`} className="ppin ppin-presence">
                            <ellipse className="ppin-shadow" cx="2" cy="1.5" rx="5" ry="1.6" />
                            <line className="ppin-needle" x1="0" y1="0" x2="0" y2="-6" />
                            <circle className="ppin-hit" cy="-8" r="7.5" role="link" tabIndex={0}
                                    aria-label={`${o.name} - see our offices`}
                                    onClick={goToOffices} onKeyDown={(e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); goToOffices(); } }}
                                    onMouseEnter={tip(o)} onMouseMove={tip(o)}
                                    onFocus={() => tipAt(o, xy)}
                                    onBlur={() => setHover(null)} />
                            <circle className="ppin-head" cy="-8" r="6.5" fill="url(#pin-presence)" />
                            <title>{o.name}</title>
                        </g>
                    );
                })}

                {/* One pin per market - tips touch the map at each market's point */}
                <g className="map-pins">
                    {pins.map(({ m, xy }) => {
                        const [x, y] = xy;
                        const isSel = m.slug === selected;
                        const type = pinClass(m);
                        return (
                            <g key={m.slug} transform={`translate(${x.toFixed(1)} ${y.toFixed(1)})`}
                               className={`ppin ppin-${type}`} data-selected={isSel ? 'true' : undefined}>
                                {isSel && <circle className="ppin-glow" cy="-8" r="15" fill="url(#pin-halo)" />}
                                <ellipse className="ppin-shadow" cx="2" cy="1.5" rx="5" ry="1.6" />
                                <line className="ppin-needle" x1="0" y1="0" x2="0" y2="-6" />
                                {/* The invisible hit disc IS the button and sits exactly on the
                                    pin head: neighbouring pins can stand only a few units apart
                                    (Sierra Leone / Liberia), so the target stays tight to the
                                    head instead of swallowing clicks meant for the next pin. */}
                                <circle className="ppin-hit" cy="-8" r="7.5" role="button" tabIndex={0}
                                        aria-label={`${m.name}, view what we do here`} aria-pressed={isSel}
                                        onClick={toggle(m)} onKeyDown={key(m)}
                                        onMouseEnter={tip(m)} onMouseMove={tip(m)}
                                        onFocus={() => tipAt(m, xy)}
                                        onBlur={() => setHover(null)} />
                                <circle className="ppin-head" cy="-8" r={isSel ? 7.5 : 6.5} fill={`url(#pin-${type})`} />
                                <title>{m.name}</title>
                            </g>
                        );
                    })}
                </g>
            </svg>

            {/* Hover card - sits above the pointer so it never covers the neighbouring pins; drops below near the top edge */}
            {hovered && (
                <div role="tooltip" className="map-tip pointer-events-none absolute z-10 w-56 rounded-xl border border-ink-100 bg-white/95 p-3 shadow-card backdrop-blur"
                     style={{ left: `${Math.min(Math.max(hover.x, 14), 86)}%`, top: `${hover.y}%`, transform: `translate(-50%, ${hover.y < 30 ? '18px' : 'calc(-100% - 18px)'})` }}>
                    <p className="text-[10px] font-bold uppercase tracking-wider text-brand-700">{hovered.region ?? hovered.city ?? 'Office'}</p>
                    <p className="mt-0.5 text-sm font-semibold text-ink-900">{hovered.name}</p>
                    {hovered.description && <p className="mt-1 line-clamp-3 text-xs leading-relaxed text-ink-600">{hovered.description}</p>}
                    {hovered.address && <p className="mt-1 line-clamp-2 text-xs leading-relaxed text-ink-600">{hovered.address}</p>}
                    <p className="mt-1.5 text-[11px] font-bold text-brand-700">
                        {hovered.slug?.startsWith('office-') ? 'See our offices' : active?.slug === hovered.slug ? 'Selected' : 'Click to explore'}
                    </p>
                </div>
            )}
        </div>
    );
}
