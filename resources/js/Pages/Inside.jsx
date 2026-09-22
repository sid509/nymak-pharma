import { Link } from '@inertiajs/react';
import { ArrowRight, MapPin, Package, Pill, ShieldCheck } from 'lucide-react';
import { useState } from 'react';
import Markdown from '../Components/Markdown';
import { CountUp, Reveal, useScrollProgress } from '../Components/Motion';
import { ButtonLink, Container } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

/**
 * Inside Nymak — the interactive company story (Experience mode).
 * Focal moment: the journey rail + the market explorer crossfade.
 * Every visible value comes from DB: content slots, stats, timeline,
 * portfolio markets, categories, leadership.
 */
export default function Inside({ seo, content, stats, timeline, portfolio, categories, leadership }) {
    const [active, setActive] = useState(0);
    const market = portfolio[active];
    const [railRef, railProgress] = useScrollProgress();

    return (
        <SiteLayout>
            {/* ── Act I · Arrival ─────────────────────────────── */}
            <section className="relative overflow-hidden bg-ink-950 py-20 text-white sm:py-28">
                <div aria-hidden className="absolute inset-0 opacity-[0.07]"
                     style={{ backgroundImage: 'radial-gradient(circle at 1px 1px, #fff 1px, transparent 0)', backgroundSize: '28px 28px' }} />
                <Container className="relative">
                    <Reveal className="reveal-clip">
                        <p className="text-xs font-bold uppercase tracking-[0.28em] text-brand-300">{content.hero_eyebrow}</p>
                    </Reveal>
                    <Reveal delay={90}>
                        <h1 className="mt-4 max-w-4xl text-4xl font-extrabold tracking-tight sm:text-6xl lg:text-7xl">
                            {content.hero_title}
                        </h1>
                    </Reveal>
                    <Reveal delay={180}>
                        <p className="mt-6 max-w-xl text-lg leading-relaxed text-ink-300">{content.hero_lead}</p>
                    </Reveal>
                    <Reveal delay={260}>
                        <dl className="mt-12 grid max-w-2xl grid-cols-2 gap-8 sm:grid-cols-4">
                            {[['years', 'Years of Lifecare'], ['countries', 'Export Countries'],
                              ['containers_fy', 'Containers in FY 23–24'], ['products', 'Products in Portfolio']]
                                .map(([key, label]) => (
                                    <div key={key}>
                                        <dt className="sr-only">{label}</dt>
                                        <dd className="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                                            <CountUp value={stats[key]} />
                                        </dd>
                                        <dd className="mt-1 text-[11px] font-bold uppercase tracking-[0.18em] text-brand-300">{label}</dd>
                                    </div>
                                ))}
                        </dl>
                    </Reveal>
                </Container>
            </section>

            {/* ── Act II · The journey rail ────────────────────── */}
            <section className="py-16 sm:py-24">
                <Container>
                    <Reveal><p className="text-xs font-bold uppercase tracking-[0.2em] text-brand-700">{content.story_eyebrow}</p></Reveal>
                    <Reveal delay={60}><h2 className="mt-3 text-3xl font-extrabold tracking-tight text-ink-950 sm:text-4xl">{content.story_title}</h2></Reveal>

                    <ol ref={railRef} className="story-rail mt-12 space-y-6"
                        style={{ '--rail': railProgress }}>
                        {timeline.map((t, i) => (
                            <Reveal key={t.year} delay={i * 60}>
                                <li className="relative pl-16 sm:pl-20">
                                    <span className="story-node" aria-hidden>{t.year}</span>
                                    <div className="rounded-2xl border border-ink-100 bg-white p-6 shadow-card sm:p-7">
                                        <h3 className="text-lg font-extrabold text-ink-900 sm:text-xl">{t.title}</h3>
                                        <p className="mt-2 leading-relaxed text-ink-600">{t.text}</p>
                                    </div>
                                </li>
                            </Reveal>
                        ))}
                    </ol>
                </Container>
            </section>

            {/* ── Act III · Market explorer ────────────────────── */}
            <section className="border-y border-ink-100 bg-ink-50/50 py-16 sm:py-24">
                <Container>
                    <Reveal><p className="text-xs font-bold uppercase tracking-[0.2em] text-brand-700">{content.explorer_eyebrow}</p></Reveal>
                    <Reveal delay={60}>
                        <h2 className="mt-3 max-w-2xl text-3xl font-extrabold tracking-tight text-ink-950 sm:text-4xl">{content.explorer_title}</h2>
                    </Reveal>
                    <Reveal delay={110}><p className="mt-4 max-w-xl text-ink-600">{content.explorer_lead}</p></Reveal>

                    <div className="mt-10 grid gap-8 lg:grid-cols-[minmax(0,22rem)_1fr]">
                        {/* Selector rail — keyboard-navigable buttons */}
                        <Reveal>
                            <div className="flex flex-wrap gap-2 lg:flex-col lg:gap-1.5" role="tablist" aria-label="Markets">
                                {portfolio.map((m, i) => (
                                    <button key={m.name} role="tab" aria-selected={i === active}
                                            data-active={i === active}
                                            onClick={() => setActive(i)}
                                            className={`market-chip flex items-center gap-2 rounded-lg border px-3.5 py-2.5 text-sm font-bold lg:w-full ${
                                                i === active
                                                    ? 'border-brand-700 bg-brand-700 text-white shadow-md shadow-brand-900/20'
                                                    : 'border-ink-200 bg-white text-ink-700 hover:border-brand-300 hover:text-brand-800'}`}>
                                        <MapPin size={14} className={i === active ? 'text-brand-200' : 'text-ink-400'} aria-hidden />
                                        {m.name}
                                        <span className={`ml-auto text-[10px] font-bold uppercase tracking-wider ${i === active ? 'text-brand-200' : 'text-ink-400'}`}>
                                            {m.region}
                                        </span>
                                    </button>
                                ))}
                            </div>
                        </Reveal>

                        {/* Detail panel — crossfades on selection */}
                        <Reveal delay={80}>
                            {market && (
                                <div key={market.name}
                                     className="explorer-panel rounded-2xl border border-ink-100 bg-white p-7 shadow-card sm:p-9">
                                    <div className="flex flex-wrap items-center gap-3">
                                        <h3 className="text-2xl font-extrabold tracking-tight text-ink-950">{market.name}</h3>
                                        <span className="rounded-full bg-brand-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-brand-700">{market.region}</span>
                                    </div>
                                    {market.description && (
                                        <div className="prose-nymak mt-4 max-w-2xl text-ink-600">
                                            <Markdown body={market.description} />
                                        </div>
                                    )}
                                    {market.products.length > 0 ? (
                                        <div className="mt-6 border-t border-ink-100 pt-5">
                                            <p className="mb-3 flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-ink-500">
                                                <Package size={13} aria-hidden /> Products supplied — {market.products.length}
                                            </p>
                                            <ul className="grid gap-2 sm:grid-cols-2">
                                                {market.products.map((p) => (
                                                    <li key={p.url}>
                                                        <Link href={p.url}
                                                              className="group flex items-center justify-between gap-2 rounded-lg border border-ink-100 bg-white px-3.5 py-2.5 text-sm font-semibold text-ink-800 transition-colors hover:border-brand-300 hover:bg-brand-50/50">
                                                            <span>{p.name}</span>
                                                            <ArrowRight size={14} className="shrink-0 text-ink-300 transition-transform group-hover:translate-x-0.5 group-hover:text-brand-600" aria-hidden />
                                                        </Link>
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    ) : (
                                        <p className="mt-5 rounded-lg bg-ink-50 px-4 py-3 text-sm text-ink-500">
                                            Relationship active — product registrations in progress.
                                        </p>
                                    )}
                                </div>
                            )}
                        </Reveal>
                    </div>
                </Container>
            </section>

            {/* ── Act IV · What we make ────────────────────────── */}
            <section className="py-16 sm:py-24">
                <Container>
                    <Reveal><p className="text-xs font-bold uppercase tracking-[0.2em] text-brand-700">The Portfolio</p></Reveal>
                    <div className="mt-8 divide-y divide-ink-100 border-y border-ink-100">
                        {categories.map((c, i) => (
                            <Reveal key={c.slug} delay={i * 50}>
                                <Link href={`/products/${c.slug}`}
                                      className="group flex items-baseline justify-between gap-6 py-6 transition-colors hover:bg-brand-50/40 sm:px-4">
                                    <span className="flex items-baseline gap-5">
                                        <span className="grid h-10 w-10 shrink-0 translate-y-2 place-items-center rounded-xl bg-brand-50 text-brand-700 transition-colors group-hover:bg-brand-700 group-hover:text-white">
                                            <Pill size={17} aria-hidden />
                                        </span>
                                        <span>
                                            <span className="block text-lg font-extrabold text-ink-900 group-hover:text-brand-800 sm:text-xl">{c.name}</span>
                                            {c.intro && <span className="mt-1 block max-w-xl text-sm leading-relaxed text-ink-500">{c.intro}</span>}
                                        </span>
                                    </span>
                                    <span className="flex shrink-0 items-center gap-3">
                                        <span className="text-xs font-bold uppercase tracking-wider text-ink-400">{c.products_count} items</span>
                                        <ArrowRight size={16} className="text-ink-300 transition-transform group-hover:translate-x-1 group-hover:text-brand-700" aria-hidden />
                                    </span>
                                </Link>
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {/* ── Act V · Leadership strip ─────────────────────── */}
            <section className="border-t border-ink-100 py-16 sm:py-20">
                <Container>
                    <Reveal><p className="text-xs font-bold uppercase tracking-[0.2em] text-brand-700">Leadership</p></Reveal>
                    <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {leadership.map((m, i) => (
                            <Reveal key={m.slug || m.name} delay={i * 60}>
                                {m.has_page ? (
                                    <Link href={`/team/${m.slug}`} className="group flex items-center gap-4 rounded-xl border border-ink-100 bg-white p-4 transition-shadow hover:shadow-md">
                                        <LeadershipAvatar m={m} />
                                        <span>
                                            <span className="block text-sm font-bold text-ink-900 group-hover:text-brand-800">{m.name}</span>
                                            <span className="block text-xs font-semibold text-brand-700">{m.role}</span>
                                        </span>
                                    </Link>
                                ) : (
                                    <div className="flex items-center gap-4 rounded-xl border border-ink-100 bg-white p-4">
                                        <LeadershipAvatar m={m} />
                                        <span>
                                            <span className="block text-sm font-bold text-ink-900">{m.name}</span>
                                            <span className="block text-xs font-semibold text-brand-700">{m.role}</span>
                                        </span>
                                    </div>
                                )}
                            </Reveal>
                        ))}
                    </div>
                    <Reveal delay={120}>
                        <Link href="/team" className="mt-6 inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 hover:underline">
                            Meet the full team <ArrowRight size={14} className="btn-arrow" aria-hidden />
                        </Link>
                    </Reveal>
                </Container>
            </section>

            {/* ── Closing CTA ──────────────────────────────────── */}
            <section className="bg-brand-700 py-16 text-white sm:py-20">
                <Container className="flex flex-wrap items-end justify-between gap-8">
                    <Reveal className="max-w-xl">
                        <ShieldCheck size={28} className="text-brand-200" aria-hidden />
                        <h2 className="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">{content.cta_title}</h2>
                        <p className="mt-3 leading-relaxed text-brand-100">{content.cta_body}</p>
                    </Reveal>
                    <Reveal delay={100}>
                        <ButtonLink href="/contact" variant="light">Start a conversation <ArrowRight size={16} className="btn-arrow" aria-hidden /></ButtonLink>
                    </Reveal>
                </Container>
            </section>
        </SiteLayout>
    );
}

function LeadershipAvatar({ m }) {
    return m.photo ? (
        <img src={`/${m.photo}`} alt="" loading="lazy" className="h-14 w-14 rounded-full object-cover object-top" />
    ) : (
        <span className="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-100 text-base font-extrabold text-brand-800">
            {m.initials}
        </span>
    );
}
