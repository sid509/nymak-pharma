import { Link } from '@inertiajs/react';
import { useRef, useState } from 'react';
import { ArrowDownRight, ArrowRight, ArrowUpRight, FileImage, Globe2, Inbox, Package, TrendingUp } from 'lucide-react';
import AdminLayout from '../../Layouts/AdminLayout';
import { CountryFlag } from '../../Components/Ui';

const PIE_COLORS = ['#22a52e', '#0086d4', '#8ae396', '#0072b5', '#748f99', '#1c8a2a'];

const CHART_W = 720;
const CHART_H = 220;
const PAD = { t: 14, r: 8, b: 26, l: 30 };

/** Smooth area+line path builder (midpoint quadratic). */
function smoothPath(pts) {
    if (pts.length < 2) return '';
    let d = `M ${pts[0][0]},${pts[0][1]}`;
    for (let i = 1; i < pts.length; i++) {
        const [x0, y0] = pts[i - 1];
        const [x1, y1] = pts[i];
        const mx = (x0 + x1) / 2;
        d += ` Q ${x0},${y0} ${mx},${(y0 + y1) / 2}`;
    }
    d += ` T ${pts[pts.length - 1][0]},${pts[pts.length - 1][1]}`;
    return d;
}

/** 30-day enquiry trend — hand-rolled SVG so SSR output is deterministic. */
function TrendChart({ data }) {
    const ref = useRef(null);
    const [hover, setHover] = useState(null);
    const max = Math.max(...data.map((d) => d.n), 1);
    const yMax = Math.ceil(max * 1.2) || 1;
    const iw = CHART_W - PAD.l - PAD.r;
    const ih = CHART_H - PAD.t - PAD.b;
    const px = (i) => PAD.l + (i / (data.length - 1)) * iw;
    const py = (v) => PAD.t + ih - (v / yMax) * ih;

    const pts = data.map((d, i) => [px(i), py(d.n)]);
    const line = smoothPath(pts);
    const area = `${line} L ${px(data.length - 1)},${PAD.t + ih} L ${px(0)},${PAD.t + ih} Z`;
    const gridVals = [0.25, 0.5, 0.75, 1].map((f) => Math.round(yMax * f));
    const labelIdx = [0, 6, 12, 18, 24, 29];

    function onMove(e) {
        const box = ref.current.getBoundingClientRect();
        const x = ((e.clientX - box.left) / box.width) * CHART_W;
        const i = Math.round(((x - PAD.l) / iw) * (data.length - 1));
        setHover(Math.max(0, Math.min(data.length - 1, i)));
    }

    const tip = hover != null ? { x: (px(hover) / CHART_W) * 100, y: (py(data[hover].n) / CHART_H) * 100 } : null;

    return (
        <div className="relative">
            <svg ref={ref} viewBox={`0 0 ${CHART_W} ${CHART_H}`} className="w-full"
                 onMouseMove={onMove} onMouseLeave={() => setHover(null)} role="img"
                 aria-label={`Enquiries over the last 30 days, peak ${max} in a day`}>
                <defs>
                    <linearGradient id="eqFill" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stopColor="#22a52e" stopOpacity="0.25" />
                        <stop offset="100%" stopColor="#22a52e" stopOpacity="0.02" />
                    </linearGradient>
                </defs>
                {gridVals.map((v, gi) => (
                    <g key={gi}>
                        <line x1={PAD.l} x2={CHART_W - PAD.r} y1={py(v)} y2={py(v)} stroke="#e4eaec" strokeDasharray="3 4" />
                        <text x={PAD.l - 8} y={py(v) + 3} textAnchor="end" fontSize="10" fill="#748f99">{v}</text>
                    </g>
                ))}
                <line x1={PAD.l} x2={CHART_W - PAD.r} y1={PAD.t + ih} y2={PAD.t + ih} stroke="#c7d3d7" />
                {labelIdx.map((i) => data[i] && (
                    <text key={i} x={px(i)} y={CHART_H - 8} textAnchor="middle" fontSize="10" fill="#748f99">{data[i].day}</text>
                ))}
                <path d={area} fill="url(#eqFill)" />
                <path d={line} fill="none" stroke="#22a52e" strokeWidth="2.5" strokeLinecap="round" />
                {hover != null && (
                    <g>
                        <line x1={px(hover)} x2={px(hover)} y1={PAD.t} y2={PAD.t + ih} stroke="#8ae396" />
                        <circle cx={px(hover)} cy={py(data[hover].n)} r="4.5" fill="#22a52e" stroke="#fff" strokeWidth="2" />
                    </g>
                )}
            </svg>
            {tip && (
                <div className="pointer-events-none absolute -translate-x-1/2 -translate-y-[130%] rounded-lg border border-ink-200 bg-white px-2.5 py-1.5 text-xs shadow-card"
                     style={{ left: `${tip.x}%`, top: `${tip.y}%` }}>
                    <p className="font-bold text-ink-900">{data[hover].n} {data[hover].n === 1 ? 'enquiry' : 'enquiries'}</p>
                    <p className="text-ink-500">{data[hover].day}</p>
                </div>
            )}
        </div>
    );
}

/** Product-mix donut — SVG segments, deterministic under SSR. */
function DonutChart({ segments }) {
    const total = Math.max(segments.reduce((s, c) => s + c.products_count, 0), 1);
    const R = 56;
    const C = 2 * Math.PI * R;
    let acc = 0;
    return (
        <svg viewBox="0 0 144 144" className="h-full w-full" role="img"
             aria-label={`${total} products across ${segments.length} categories`}>
            <circle cx="72" cy="72" r={R} fill="none" stroke="#e4eaec" strokeWidth="18" />
            {segments.map((s, i) => {
                const frac = s.products_count / total;
                const dash = `${frac * C} ${C}`;
                const off = -acc * C + C * 0.25;
                acc += frac;
                return (
                    <circle key={s.slug} cx="72" cy="72" r={R} fill="none"
                            stroke={PIE_COLORS[i % PIE_COLORS.length]} strokeWidth="18"
                            strokeDasharray={dash} strokeDashoffset={off} strokeLinecap="butt">
                        <title>{s.name}: {s.products_count}</title>
                    </circle>
                );
            })}
            <text x="72" y="68" textAnchor="middle" fontSize="22" fontWeight="800" fill="#16293a">{total}</text>
            <text x="72" y="86" textAnchor="middle" fontSize="9.5" fontWeight="600" fill="#748f99">PRODUCTS</text>
        </svg>
    );
}

function Panel({ title, action, children, className = '' }) {
    return (
        <div className={`rounded-xl border border-ink-200 bg-white ${className}`}>
            <div className="flex items-center justify-between border-b border-ink-100 px-5 py-3.5">
                <h2 className="text-sm font-bold text-ink-900">{title}</h2>
                {action}
            </div>
            {children}
        </div>
    );
}

function ViewAll({ href }) {
    return (
        <Link href={href} className="inline-flex items-center gap-1 text-xs font-bold text-brand-700 hover:underline">
            View all <ArrowRight size={12} className="btn-arrow" aria-hidden />
        </Link>
    );
}

export default function Dashboard({ stats, enquiryTrend, enquiriesByCountry, productsByCategory, productsByMarket, enquiriesByProduct, recentEnquiries }) {
    const kpis = [
        { label: 'Unread enquiries', value: stats.enquiries_unread, href: '/admin/enquiries?status=unread', icon: Inbox, accent: stats.enquiries_unread > 0, sub: 'needs a reply' },
        { label: 'Enquiries · 30 days', value: stats.enquiries_30d, href: '/admin/enquiries', icon: TrendingUp, delta: stats.enquiries_30d_delta, sub: `of ${stats.enquiries_total} total` },
        { label: 'Products', value: stats.products, href: '/admin/products', icon: Package, sub: `${stats.products_with_pages} with detail pages` },
        { label: 'Markets served', value: stats.markets, href: '/admin/markets', icon: Globe2, sub: `${stats.categories} product categories` },
    ];

    const secondary = [
        { label: 'Published articles', value: stats.posts_published, href: '/admin/posts' },
        { label: 'Draft articles', value: stats.posts_draft, href: '/admin/posts?status=draft' },
        { label: 'Team members', value: stats.team, href: '/admin/team-members' },
        { label: 'Detail pages missing image', value: stats.products_no_image, href: '/admin/products' },
    ];

    const maxCountry = Math.max(...enquiriesByCountry.map((c) => c.n), 1);
    const maxMarket = Math.max(...productsByMarket.map((m) => m.products_count), 1);
    const health = [
        { label: 'Detail pages with images', done: stats.products_with_pages - stats.products_no_image, total: stats.products_with_pages },
        { label: 'Products with detail pages', done: stats.products_with_pages, total: stats.products },
        { label: 'Articles published', done: stats.posts_published, total: stats.posts_published + stats.posts_draft },
    ];

    return (
        <AdminLayout title="Dashboard">
            {/* Hero KPIs */}
            <div className="grid grid-cols-2 gap-3 lg:grid-cols-4">
                {kpis.map((c) => (
                    <Link key={c.label} href={c.href}
                          className={`group rounded-xl border p-4 transition-all hover:-translate-y-0.5 hover:shadow-card ${c.accent ? 'border-brand-300 bg-brand-50/60' : 'border-ink-200 bg-white'}`}>
                        <div className="flex items-center justify-between">
                            <span className={`inline-flex h-8 w-8 items-center justify-center rounded-lg ${c.accent ? 'bg-brand-600 text-white' : 'bg-ink-50 text-ink-500'}`}>
                                <c.icon size={16} aria-hidden />
                            </span>
                            {c.delta != null && (
                                <span className={`inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-[11px] font-bold ${c.delta >= 0 ? 'bg-brand-50 text-brand-700' : 'bg-red-50 text-red-600'}`}>
                                    {c.delta >= 0 ? <ArrowUpRight size={11} aria-hidden /> : <ArrowDownRight size={11} aria-hidden />}
                                    {Math.abs(c.delta)}%
                                </span>
                            )}
                        </div>
                        <p className="mt-3 text-3xl font-extrabold tabular-nums text-ink-900">{c.value}</p>
                        <p className="mt-0.5 text-xs font-semibold text-ink-600">{c.label}</p>
                        {c.sub && <p className="text-[11px] text-ink-400">{c.sub}</p>}
                    </Link>
                ))}
            </div>

            {/* Secondary counts */}
            <div className="mt-3 flex flex-wrap gap-2">
                {secondary.map((s) => (
                    <Link key={s.label} href={s.href}
                          className="inline-flex items-center gap-2 rounded-full border border-ink-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-ink-600 transition-colors hover:border-brand-300 hover:text-brand-800">
                        <span className="tabular-nums font-bold text-ink-900">{s.value}</span> {s.label}
                    </Link>
                ))}
            </div>

            {/* Trend + geography */}
            <div className="mt-6 grid gap-4 lg:grid-cols-3">
                <Panel title="Enquiries — last 30 days" className="lg:col-span-2"
                       action={<span className="text-xs font-semibold text-ink-400">{stats.enquiries_30d} this period</span>}>
                    <div className="px-3 py-4">
                        <TrendChart data={enquiryTrend} />
                    </div>
                </Panel>

                <Panel title="Enquiries by country" action={<ViewAll href="/admin/enquiries" />}>
                    {enquiriesByCountry.length === 0 ? (
                        <p className="px-5 py-8 text-center text-sm text-ink-400">No country data yet.</p>
                    ) : (
                        <ul className="space-y-3 px-5 py-4">
                            {enquiriesByCountry.map((c) => (
                                <li key={c.country}>
                                    <div className="mb-1 flex items-center justify-between text-xs">
                                        <span className="font-semibold text-ink-800">{c.country}</span>
                                        <span className="tabular-nums font-bold text-ink-500">{c.n}</span>
                                    </div>
                                    <div className="h-1.5 overflow-hidden rounded-full bg-ink-100">
                                        <div className="h-full rounded-full bg-gradient-to-r from-brand-600 to-gold-500 transition-all"
                                             style={{ width: `${(c.n / maxCountry) * 100}%` }} />
                                    </div>
                                </li>
                            ))}
                        </ul>
                    )}
                </Panel>
            </div>

            {/* Catalogue insight */}
            <div className="mt-4 grid gap-4 lg:grid-cols-3">
                <Panel title="Product mix" action={<ViewAll href="/admin/products" />}>
                    <div className="flex items-center gap-4 px-5 py-4">
                        <div className="h-36 w-36 shrink-0">
                            <DonutChart segments={productsByCategory} />
                        </div>
                        <ul className="min-w-0 flex-1 space-y-1.5">
                            {productsByCategory.map((cat, i) => (
                                <li key={cat.slug} className="flex items-center gap-2 text-xs">
                                    <span className="h-2 w-2 shrink-0 rounded-full" style={{ background: PIE_COLORS[i % PIE_COLORS.length] }} aria-hidden />
                                    <span className="min-w-0 flex-1 truncate font-medium text-ink-700">{cat.name}</span>
                                    <span className="tabular-nums font-bold text-ink-500">{cat.products_count}</span>
                                </li>
                            ))}
                        </ul>
                    </div>
                </Panel>

                <Panel title="Branded range by market" action={<ViewAll href="/admin/markets" />}>
                    {productsByMarket.length === 0 ? (
                        <p className="px-5 py-8 text-center text-sm text-ink-400">No market-linked products yet.</p>
                    ) : (
                        <ul className="space-y-3 px-5 py-4">
                            {productsByMarket.map((m) => (
                                <li key={m.slug}>
                                    <div className="mb-1 flex items-center justify-between text-xs">
                                        <span className="flex items-center gap-2 font-semibold text-ink-800">
                                            <CountryFlag iso={m.iso_code} className="h-3.5 w-5 rounded-sm" iconClass="h-3.5 w-3.5" />
                                            {m.name}
                                        </span>
                                        <span className="tabular-nums font-bold text-ink-500">{m.products_count}</span>
                                    </div>
                                    <div className="h-1.5 overflow-hidden rounded-full bg-ink-100">
                                        <div className="h-full rounded-full bg-gold-500 transition-all"
                                             style={{ width: `${(m.products_count / maxMarket) * 100}%` }} />
                                    </div>
                                </li>
                            ))}
                        </ul>
                    )}
                </Panel>

                <Panel title="Content health" action={<ViewAll href="/admin/products" />}>
                    <ul className="space-y-4 px-5 py-4">
                        {health.map((h) => {
                            const pct = h.total > 0 ? Math.round((h.done / h.total) * 100) : 0;
                            return (
                                <li key={h.label}>
                                    <div className="mb-1 flex items-center justify-between text-xs">
                                        <span className="font-semibold text-ink-800">{h.label}</span>
                                        <span className={`tabular-nums font-bold ${pct === 100 ? 'text-brand-700' : 'text-ink-500'}`}>{h.done}/{h.total}</span>
                                    </div>
                                    <div className="h-1.5 overflow-hidden rounded-full bg-ink-100">
                                        <div className={`h-full rounded-full transition-all ${pct === 100 ? 'bg-brand-500' : pct > 60 ? 'bg-brand-400' : 'bg-gold-500'}`}
                                             style={{ width: `${pct}%` }} />
                                    </div>
                                </li>
                            );
                        })}
                    </ul>
                    {stats.products_no_image > 0 && (
                        <p className="mx-5 mb-4 flex items-center gap-2 rounded-lg bg-gold-50 px-3 py-2 text-[11px] font-semibold text-gold-600">
                            <FileImage size={13} aria-hidden />
                            {stats.products_no_image} detail {stats.products_no_image === 1 ? 'page needs' : 'pages need'} a packshot
                        </p>
                    )}
                </Panel>
            </div>

            {/* Latest activity */}
            <div className="mt-4 grid gap-4 lg:grid-cols-3">
                <Panel title="Latest enquiries" className="lg:col-span-2" action={<ViewAll href="/admin/enquiries" />}>
                    {recentEnquiries.length === 0 ? (
                        <p className="px-5 py-8 text-center text-sm text-ink-400">No enquiries yet.</p>
                    ) : (
                        <ul className="divide-y divide-ink-100">
                            {recentEnquiries.map((e) => (
                                <li key={e.id}>
                                    <Link href="/admin/enquiries" className="flex items-center gap-3 px-5 py-3 hover:bg-ink-50/60">
                                        {!e.read_at && <span className="h-2 w-2 shrink-0 rounded-full bg-brand-500" title="Unread" />}
                                        <span className={`min-w-0 flex-1 ${e.read_at ? 'text-ink-600' : 'font-semibold text-ink-900'}`}>
                                            <span className="block truncate text-sm">{e.subject || e.name}</span>
                                            <span className="block truncate text-xs text-ink-400">{e.name}{e.company ? ` · ${e.company}` : ''}{e.country ? ` · ${e.country}` : ''}</span>
                                        </span>
                                        <span className="shrink-0 text-xs text-ink-400">{e.when}</span>
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    )}
                </Panel>

                <Panel title="Most-enquired products" action={<ViewAll href="/admin/enquiries" />}>
                    {enquiriesByProduct.length === 0 ? (
                        <p className="px-5 py-8 text-center text-sm text-ink-400">No product enquiries yet.</p>
                    ) : (
                        <ul className="divide-y divide-ink-100">
                            {enquiriesByProduct.map((p, i) => (
                                <li key={p.name} className="flex items-center gap-3 px-5 py-3">
                                    <span className={`inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[11px] font-bold ${i === 0 ? 'bg-brand-600 text-white' : 'bg-ink-50 text-ink-500'}`}>
                                        {i + 1}
                                    </span>
                                    <span className="min-w-0 flex-1 truncate text-sm font-medium text-ink-800">{p.name}</span>
                                    <span className="tabular-nums shrink-0 text-xs font-bold text-ink-500">{p.n}</span>
                                </li>
                            ))}
                        </ul>
                    )}
                </Panel>
            </div>
        </AdminLayout>
    );
}
