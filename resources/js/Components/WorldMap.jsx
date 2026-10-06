import { geoCentroid, geoDistance, geoGraticule10, geoInterpolate, geoOrthographic, geoPath } from 'd3-geo';
import { useEffect, useMemo, useRef, useState } from 'react';
import { feature } from 'topojson-client';
import world from 'world-atlas/countries-110m.json';
import { numericId } from '../data/countries';

/**
 * Interactive globe — an airline-style view of the supply network. India is
 * the hub: a gold marker at Mundra sends a great-circle route arc to every
 * market. The globe slowly auto-rotates, can be dragged, and swings around to
 * any market picked on the map or from the list. Pure SVG + d3-geo: it
 * renders on the server, needs no tiles or API keys, and styles with the
 * brand palette.
 */

const SIZE = 760;
const CENTER = SIZE / 2;
const RADIUS = 315;
const HQ = [69.72, 22.74]; // Mundra, Gujarat — Nymak's manufacturing base
const HOME = { lambda: 52, phi: 16 }; // opening view: India hub right-of-centre, Africa in frame
const AUTO_SPEED = 0.06; // degrees per tick (~1.8°/s)
const RESUME_DELAY = 2600; // ms after drag before auto-rotation resumes

const features = feature(world, world.objects.countries).features;
const byId = new Map(features.map((f) => [f.id, f]));
const GRATICULE = geoGraticule10();

const clamp = (v, lo, hi) => Math.min(Math.max(v, lo), hi);
const reduced = () => typeof window !== 'undefined'
    && typeof window.matchMedia === 'function'
    && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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

export default function WorldMap({ markets, selected, onSelect, className = '' }) {
    const [view, setView] = useState(HOME); // centered geo point {lambda, phi}
    const [hover, setHover] = useState(null); // { slug, x, y }
    const [dragging, setDragging] = useState(false);
    const viewRef = useRef(view);
    viewRef.current = view;
    const svgRef = useRef(null);
    const drag = useRef(null); // { x, y, view }
    const moved = useRef(false); // survives pointerup so the trailing click can check it
    const resumeAt = useRef(0);
    const flyRef = useRef(null);
    const pointerIn = useRef(false); // pointer over the globe — inspecting, don't rotate
    const focusIn = useRef(false); // focus inside the globe — keyboard users need a still target

    const placed = useMemo(() => placeMarkets(markets), [markets]);
    const byCountry = useMemo(() => new Map(placed.filter((m) => m.countryId).map((m) => [m.countryId, m])), [placed]);
    const active = placed.find((m) => m.slug === selected) ?? null;
    const hovered = hover ? placed.find((m) => m.slug === hover.slug) : null;

    const projection = useMemo(() => geoOrthographic()
        .rotate([-view.lambda, -view.phi])
        .translate([CENTER, CENTER])
        .scale(RADIUS), [view]);
    const path = useMemo(() => geoPath(projection), [projection]);

    const countries = useMemo(() => features
        .map((f) => ({ id: f.id, name: f.properties.name, d: path(f) }))
        .filter((c) => c.d), [path]);

    // Great-circle supply routes from Mundra to every market — the horizon
    // clips them naturally as the globe turns.
    const routes = useMemo(() => placed.filter((m) => m.point).map((m) => {
        const fly = geoInterpolate(HQ, m.point);
        const line = { type: 'LineString', coordinates: Array.from({ length: 48 }, (_, i) => fly(i / 47)) };
        return { slug: m.slug, d: path(line) };
    }).filter((r) => r.d), [placed, path]);

    const visible = (pt) => geoDistance([view.lambda, view.phi], pt) < Math.PI / 2 - 0.02;
    const pins = placed.filter((m) => m.point && visible(m.point)).map((m) => ({ m, xy: projection(m.point) }));
    const showIndia = ! byCountry.has('356');

    // Slow auto-rotation — pauses while dragging, while the pointer or focus
    // is on the globe, while animating, or while a market is selected so the
    // portfolio stays in view.
    useEffect(() => {
        if (reduced()) return undefined;
        let raf; let last = 0;
        const tick = (t) => {
            raf = requestAnimationFrame(tick);
            if (t - last < 50) return;
            last = t;
            if (drag.current || hover || selected || flyRef.current || pointerIn.current || focusIn.current || t < resumeAt.current) return;
            setView((v) => ({ lambda: v.lambda + AUTO_SPEED, phi: v.phi }));
        };
        raf = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(raf);
    }, [hover, selected]);

    // Selecting a market flies the globe round to it (shortest longitude arc);
    // clearing the selection returns to the hub view — India stays the story.
    useEffect(() => {
        const from = viewRef.current;
        let aimLon = HOME.lambda;
        let aimLat = HOME.phi;
        if (active?.point) {
            // Centre a little toward Mundra so the route back to India stays in frame.
            const [lon, lat] = active.point;
            aimLon = lon + (HQ[0] - lon) * 0.18;
            aimLat = lat + (HQ[1] - lat) * 0.18;
        }
        let dLambda = aimLon - from.lambda;
        dLambda = ((dLambda + 540) % 360) - 180;
        if (Math.abs(dLambda) < 0.5 && Math.abs(aimLat - from.phi) < 0.5) return undefined;
        const to = { lambda: from.lambda + dLambda, phi: clamp(aimLat, -72, 72) };
        if (reduced()) { setView(to); return undefined; }
        const t0 = performance.now();
        const duration = 900;
        const tick = (now) => {
            const t = Math.min(1, (now - t0) / duration);
            const e = 1 - Math.pow(1 - t, 3);
            setView({ lambda: from.lambda + dLambda * e, phi: from.phi + (to.phi - from.phi) * e });
            flyRef.current = t < 1 ? requestAnimationFrame(tick) : null;
        };
        flyRef.current = requestAnimationFrame(tick);
        return () => { if (flyRef.current) cancelAnimationFrame(flyRef.current); flyRef.current = null; };
    }, [active?.slug]); // eslint-disable-line react-hooks/exhaustive-deps

    // Drag-to-spin lives on window listeners: no pointer capture, so clicks on
    // countries still land, and drags keep working when the pointer leaves the svg.
    const down = (e) => {
        drag.current = { x: e.clientX, y: e.clientY, view: viewRef.current };
        moved.current = false;
        setDragging(true);
    };
    useEffect(() => {
        const move = (e) => {
            const s = drag.current;
            if (! s) return;
            const dx = e.clientX - s.x;
            const dy = e.clientY - s.y;
            if (Math.abs(dx) + Math.abs(dy) > 4) moved.current = true;
            const box = svgRef.current.getBoundingClientRect();
            const k = 0.28 * (SIZE / box.width); // client px → svg units → degrees
            setView({ lambda: s.view.lambda - dx * k, phi: clamp(s.view.phi + dy * k, -72, 72) });
        };
        const end = () => {
            if (! drag.current) return;
            if (moved.current) resumeAt.current = performance.now() + RESUME_DELAY;
            drag.current = null;
            setDragging(false);
        };
        window.addEventListener('pointermove', move);
        window.addEventListener('pointerup', end);
        window.addEventListener('pointercancel', end);
        return () => {
            window.removeEventListener('pointermove', move);
            window.removeEventListener('pointerup', end);
            window.removeEventListener('pointercancel', end);
        };
    }, []);

    const tip = (m) => (e) => {
        const box = e.currentTarget.ownerSVGElement.getBoundingClientRect();
        setHover({ slug: m.slug, x: ((e.clientX - box.left) / box.width) * 100, y: ((e.clientY - box.top) / box.height) * 100 });
    };
    const tipAt = (m, xy) => setHover({ slug: m.slug, x: (xy[0] / SIZE) * 100, y: (xy[1] / SIZE) * 100 });
    const key = (m) => (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); onSelect(m.slug); }
    };
    const toggle = (m) => () => {
        if (moved.current) return;
        onSelect(m.slug === selected ? null : m.slug);
    };

    return (
        <div className={`world-map relative ${className}`} onMouseLeave={() => setHover(null)}
             onFocusCapture={() => { focusIn.current = true; }}
             onBlurCapture={(e) => { if (! e.currentTarget.contains(e.relatedTarget)) focusIn.current = false; }}>
            <svg ref={svgRef} viewBox={`0 0 ${SIZE} ${SIZE}`}
                 className={`block h-auto w-full globe-svg ${dragging ? 'is-dragging' : ''}`}
                 role="group" aria-label="Globe showing the countries Nymak Pharma supplies from India"
                 onPointerDown={down}
                 onPointerEnter={() => { pointerIn.current = true; }}
                 onPointerLeave={() => { pointerIn.current = false; }}>
                <defs>
                    <radialGradient id="globe-ocean" cx="0.38" cy="0.32" r="0.85">
                        <stop offset="0%" stopColor="var(--color-brand-100)" />
                        <stop offset="55%" stopColor="var(--color-brand-50)" />
                        <stop offset="100%" stopColor="#eef4f3" />
                    </radialGradient>
                    <radialGradient id="globe-glow" r="0.5">
                        <stop offset="0%" stopColor="var(--color-gold-400)" stopOpacity="0.6" />
                        <stop offset="100%" stopColor="var(--color-gold-400)" stopOpacity="0" />
                    </radialGradient>
                </defs>

                {/* Ocean sphere + atmosphere rim */}
                <circle cx={CENTER} cy={CENTER} r={RADIUS + 14} className="globe-atmos" />
                <circle cx={CENTER} cy={CENTER} r={RADIUS} fill="url(#globe-ocean)" className="globe-ocean" />
                <path d={path(GRATICULE)} className="globe-grat" aria-hidden />

                {/* Land */}
                <g className="map-base" aria-hidden>
                    {countries.filter((c) => ! byCountry.has(c.id) && c.id !== '356').map((c) => <path key={c.id} d={c.d} />)}
                </g>
                {showIndia && countries.filter((c) => c.id === '356').map((c) => <path key={c.id} d={c.d} className="globe-hq-land" />)}
                <g className="map-active">
                    {countries.filter((c) => byCountry.has(c.id)).map((c) => {
                        const m = byCountry.get(c.id);
                        const isSel = m.slug === selected;
                        return (
                            <path key={c.id} d={c.d} role="button" tabIndex={0}
                                  aria-label={`${m.name} — view what we do here`} aria-pressed={isSel}
                                  data-featured={m.featured ? 'true' : undefined} data-selected={isSel ? 'true' : undefined}
                                  onClick={toggle(m)} onKeyDown={key(m)}
                                  onMouseEnter={tip(m)} onMouseMove={tip(m)}
                                  onFocus={() => m.point && tipAt(m, projection(m.point))}
                                  onBlur={() => setHover(null)}>
                                <title>{m.name}</title>
                            </path>
                        );
                    })}
                </g>

                {/* Supply routes — base arc plus a travelling dash, airline style.
                    pointerEvents=none: the arcs sit on top of country shapes but
                    are decorative — they must never steal a click from a market. */}
                <g className="globe-routes" aria-hidden style={{ pointerEvents: 'none' }}>
                    {routes.map((r, i) => (
                        <g key={r.slug} className={r.slug === selected ? 'is-selected' : undefined}>
                            <path d={r.d} className="globe-arc" />
                            <path d={r.d} pathLength="1" className="globe-arc-run" style={{ animationDelay: `${(i * 0.45) % 3.6}s` }} />
                        </g>
                    ))}
                </g>

                {/* Market markers — dots on every visible market, clickable pin for coordinate-only regions */}
                <g className="map-pins">
                    {pins.map(({ m, xy }) => {
                        const [x, y] = xy;
                        const isSel = m.slug === selected;
                        const pinned = ! m.countryId;
                        return (
                            <g key={m.slug} transform={`translate(${x.toFixed(1)} ${y.toFixed(1)})`}
                               className="map-pin" data-selected={isSel ? 'true' : undefined} data-featured={m.featured ? 'true' : undefined}>
                                {isSel && <circle r="22" fill="url(#globe-glow)" className="map-pin-glow" />}
                                <circle r={isSel ? 9 : 7} className="map-pin-ring" />
                                <circle r={isSel ? 4.5 : 3.5} className="map-pin-dot" />
                                {pinned && (
                                    <circle r="14" fill="transparent" role="button" tabIndex={0}
                                            aria-label={`${m.name} — view what we do here`} aria-pressed={isSel}
                                            onClick={toggle(m)} onKeyDown={key(m)}
                                            onMouseEnter={tip(m)} onMouseMove={tip(m)}
                                            onFocus={() => tipAt(m, xy)}
                                            onBlur={() => setHover(null)} className="cursor-pointer">
                                        <title>{m.name}</title>
                                    </circle>
                                )}
                            </g>
                        );
                    })}
                </g>

                {/* HQ — the origin of every route */}
                <g className="globe-hq" transform={`translate(${projection(HQ).map((n) => n.toFixed(1)).join(' ')})`}>
                    <circle r="20" fill="url(#globe-glow)" className="globe-hq-glow" />
                    <circle r="7" className="globe-hq-ring" />
                    <circle r="3.6" className="globe-hq-dot" />
                    <text y="-14" textAnchor="middle" className="globe-hq-label">Mundra · India HQ</text>
                </g>
            </svg>

            {/* Hover card — sits above the pointer so it never covers the neighbouring countries; drops below near the top edge */}
            {hovered && (
                <div role="tooltip" className="map-tip pointer-events-none absolute z-10 w-56 rounded-xl border border-ink-100 bg-white/95 p-3 shadow-card backdrop-blur"
                     style={{ left: `${Math.min(Math.max(hover.x, 14), 86)}%`, top: `${hover.y}%`, transform: `translate(-50%, ${hover.y < 30 ? '18px' : 'calc(-100% - 18px)'})` }}>
                    <p className="text-[10px] font-bold uppercase tracking-wider text-brand-700">{hovered.region}</p>
                    <p className="mt-0.5 text-sm font-semibold text-ink-900">{hovered.name}</p>
                    {hovered.description && <p className="mt-1 line-clamp-3 text-xs leading-relaxed text-ink-600">{hovered.description}</p>}
                    <p className="mt-1.5 text-[11px] font-bold text-brand-700">{active?.slug === hovered.slug ? 'Selected' : 'Click to explore →'}</p>
                </div>
            )}
        </div>
    );
}
