import { Link, usePage } from "@inertiajs/react";
import { ArrowRight, Building2, Globe2, Handshake, Mail, MapPin, MousePointerClick, Package, Phone, Route, Star, X } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { Reveal } from '../../Components/Motion';
import { ButtonLink, Container, CountryFlag, PageHero, SectionHeading, Stat, WhatsAppIcon } from '../../Components/Ui';
import WorldMap from '../../Components/WorldMap';
import SiteLayout from '../../Layouts/SiteLayout';

/** Detail panel: what we do in the selected market — rich content, products, office. */
function MarketPanel({ m, content, onClose }) {
    return (
        <div key={m.slug} className="explorer-panel flex h-full flex-col rounded-2xl border border-ink-100 bg-white shadow-card">
            <div className="flex items-start justify-between gap-4 border-b border-ink-100 p-6 sm:p-7">
                <div>
                    <p className="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">
                        <MapPin size={13} aria-hidden /> {m.region}
                        {m.featured && <span className="inline-flex items-center gap-1 rounded-full bg-brand-50 px-2 py-0.5 text-xs font-semibold text-brand-800"><Star size={10} aria-hidden /> Key market</span>}
                        {m.office && <span className="rounded-full bg-gold-100 px-2 py-0.5 text-xs font-semibold text-gold-800">Local office</span>}
                    </p>
                    <h3 className="mt-2 flex items-center gap-2.5 t-h3 text-ink-950"><CountryFlag iso={m.iso_code} className="h-6 w-8" />{m.name}</h3>
                </div>
                <button type="button" onClick={onClose} aria-label="Clear selection"
                        className="shrink-0 rounded-full p-2 text-ink-400 transition-colors hover:bg-ink-50 hover:text-ink-800">
                    <X size={16} aria-hidden />
                </button>
            </div>

            <div className="flex-1 p-6 sm:p-7">
                {m.content ? (
                    <div className="prose-nymak text-sm [&_h2]:mt-5 [&_h2]:text-lg [&_h3]:mt-5 [&_h3]:text-base [&_p]:text-sm [&_li]:text-sm"
                         dangerouslySetInnerHTML={{ __html: m.content }} />
                ) : m.description ? (
                    <p className="text-sm leading-relaxed text-ink-700">{m.description}</p>
                ) : (
                    <div className="rounded-xl border border-brand-100 bg-brand-50/60 p-5">
                        <p className="text-sm font-semibold text-ink-900">{content.map_market_empty_title.replace('{country}', m.name)}</p>
                        <p className="mt-1.5 text-sm leading-relaxed text-ink-600">{content.map_market_empty_body.replace('{country}', m.name)}</p>
                        <ButtonLink href="/contact" variant="outline" className="mt-4">
                            {content.map_market_cta} <ArrowRight size={14} className="btn-arrow" aria-hidden />
                        </ButtonLink>
                    </div>
                )}

                {m.products.length > 0 && (
                    <div className="mt-6 border-t border-ink-100 pt-5">
                        <p className="mb-3 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">
                            <Package size={12} aria-hidden /> Supplied to {m.name} — {m.products.length}
                        </p>
                        <ul className="flex flex-wrap gap-2">
                            {m.products.map((p) => (
                                <li key={p.url}>
                                    <Link href={p.url}
                                          className="group inline-flex items-center gap-1.5 rounded-full border border-ink-200 bg-white px-3 py-1.5 text-xs font-semibold text-ink-700 transition-colors hover:border-brand-300 hover:text-brand-800">
                                        {p.name}
                                        <ArrowRight size={12} className="text-ink-300 transition-transform group-hover:translate-x-0.5 group-hover:text-brand-600" aria-hidden />
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                )}
            </div>

            {m.office && (
                <address className="rounded-b-2xl border-t border-ink-100 bg-ink-50/60 px-6 py-4 text-sm not-italic text-ink-600 sm:px-7">
                    <span className="flex items-center gap-1.5 font-semibold text-ink-800"><Building2 size={14} className="text-brand-700" aria-hidden />{m.office.name}</span>
                    <span className="mt-1 block">{m.office.address}</span>
                    <span className="mt-1 flex flex-wrap gap-x-4 font-semibold text-ink-800">
                        <span className="flex items-center gap-1.5"><Phone size={13} className="text-brand-600" aria-hidden />{m.office.phone}</span>
                        {m.office.email && <a href={`mailto:${m.office.email}`} className="flex items-center gap-1.5 text-brand-700 hover:underline"><Mail size={13} aria-hidden />{m.office.email}</a>}
                    </span>
                </address>
            )}
        </div>
    );
}

function EmptyPanel({ content, markets, onPick }) {
    const picks = (markets.some((m) => m.featured) ? markets.filter((m) => m.featured) : markets).slice(0, 4);
    return (
        <div className="explorer-panel flex h-full min-h-[18rem] flex-col items-center justify-center rounded-2xl border border-dashed border-ink-200 bg-ink-50/50 p-8 text-center">
            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-white text-brand-700 shadow-card"><MousePointerClick size={22} aria-hidden /></span>
            <h3 className="mt-4 t-h4 text-ink-900">{content.map_empty_title}</h3>
            <p className="mt-2 max-w-xs text-sm leading-relaxed text-ink-600">{content.map_empty_body}</p>
            <p className="mt-4 text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{markets.length} markets across the globe</p>
            <div className="mt-4 flex flex-wrap justify-center gap-2">
                {picks.map((m) => (
                    <button key={m.slug} type="button" onClick={() => onPick(m.slug)}
                            className="inline-flex items-center gap-1.5 rounded-full border border-ink-200 bg-white px-3 py-1.5 text-xs font-semibold text-ink-700 transition-colors hover:border-brand-400 hover:bg-brand-50 hover:text-brand-800">
                        <CountryFlag iso={m.iso_code} className="h-3 w-[18px] rounded-[2px]" iconClass="h-3 w-3 text-brand-600" />{m.name}
                    </button>
                ))}
            </div>
            <ButtonLink href="/contact" variant="ghost" className="mt-4 text-sm font-semibold">
                {content.map_empty_cta} <ArrowRight size={14} className="btn-arrow" aria-hidden />
            </ButtonLink>
        </div>
    );
}

export default function MarketsIndex({ seo, markets, offices, content }) {
    const { site } = usePage().props;
    const [selected, setSelected] = useState(null);
    const panelRef = useRef(null);
    const active = markets.find((m) => m.slug === selected) ?? null;
    const regions = [...new Set(markets.map((m) => m.region).filter(Boolean))];

    // Deep-link support: /global-presence#nigeria opens that market, on load
    // and when the hash changes without a reload (back/forward, in-page links).
    useEffect(() => {
        const fromHash = () => {
            const slug = window.location.hash.slice(1);
            if (slug && markets.some((m) => m.slug === slug)) setSelected(slug);
        };
        fromHash();
        window.addEventListener('hashchange', fromHash);
        return () => window.removeEventListener('hashchange', fromHash);
    }, [markets]);

    const select = (slug) => {
        setSelected(slug);
        history.replaceState(null, '', slug ? `#${slug}` : window.location.pathname);
        // On narrow screens the panel sits below the map — bring it into view.
        if (slug && window.matchMedia('(max-width: 1023px)').matches) {
            requestAnimationFrame(() => panelRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
        }
    };

    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Global Presence']]}
                title={content.hero_title}
                lead={content.hero_lead} tone="dark" align="center">
                <dl className="mx-auto mt-10 grid max-w-3xl grid-cols-2 gap-3 text-left sm:grid-cols-4">
                    {[
                        [Globe2, `${markets.length}+`, 'Countries served'],
                        [Route, regions.length, 'Regions'],
                        [Star, markets.filter((m) => m.featured).length || markets.length, 'Key markets'],
                        [Building2, offices.length, 'International offices'],
                    ].map(([Icon, value, label]) => (
                        <div key={label} className="rounded-xl border border-white/10 bg-white/5 px-4 py-3 backdrop-blur-sm">
                            <p className="flex items-center gap-2 text-lg font-semibold text-white">
                                <Icon size={15} className="text-brand-300" aria-hidden />{value}
                            </p>
                            <dt className="mt-0.5 text-xs font-semibold uppercase tracking-[0.04em] text-white/50">{label}</dt>
                        </div>
                    ))}
                </dl>
            </PageHero>

            {/* Interactive map + detail panel */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.map_eyebrow} title={content.map_title} lead={content.map_lead} />

                    <div className="mt-10 grid gap-6 lg:grid-cols-[minmax(0,1.55fr)_minmax(20rem,1fr)] lg:gap-8">
                        <Reveal>
                            <div className="rounded-3xl border border-ink-100 bg-gradient-to-b from-white to-brand-50/40 p-3 shadow-card sm:p-5">
                                <WorldMap markets={markets} selected={selected} onSelect={select} />
                                <ul className="mt-3 flex flex-wrap items-center gap-x-5 gap-y-1.5 px-2 text-xs font-semibold text-ink-500" aria-label="Legend">
                                    <li className="flex items-center gap-1.5"><span className="h-2.5 w-2.5 rounded-full bg-gold-500 ring-2 ring-gold-100" aria-hidden />Mundra HQ</li>
                                    <li className="flex items-center gap-1.5"><span className="h-2.5 w-2.5 rounded-sm bg-brand-600" aria-hidden />Key market</li>
                                    <li className="flex items-center gap-1.5"><span className="h-2.5 w-2.5 rounded-sm bg-brand-400" aria-hidden />Export market</li>
                                    <li className="flex items-center gap-1.5"><span className="inline-block h-0.5 w-5 rounded-full bg-gold-500" aria-hidden />Supply route</li>
                                    <li className="ml-auto italic text-ink-400">Drag to spin · click a country</li>
                                </ul>
                            </div>
                        </Reveal>

                        <Reveal delay={80}>
                            <div ref={panelRef} className="scroll-mt-28 lg:sticky lg:top-28">
                                {active ? <MarketPanel m={active} content={content} onClose={() => select(null)} /> : <EmptyPanel content={content} markets={markets} onPick={select} />}
                            </div>
                        </Reveal>
                    </div>

                    {/* Region-grouped list — the same selection, reachable without the map */}
                    <div className="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        {regions.map((region, i) => (
                            <Reveal key={region} delay={Math.min(i * 50, 200)}>
                                <h3 className="text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{region}</h3>
                                <ul className="mt-3 space-y-1.5">
                                    {markets.filter((m) => m.region === region).map((m) => {
                                        const isSel = m.slug === selected;
                                        return (
                                            <li key={m.slug}>
                                                <button type="button" onClick={() => select(isSel ? null : m.slug)} aria-pressed={isSel}
                                                        className={`map-list-btn flex w-full items-center gap-2 rounded-lg border px-3 py-2 text-left text-sm ${
                                                            isSel ? 'border-gold-500 bg-gold-50 font-semibold text-ink-900'
                                                                : m.featured ? 'border-brand-200 bg-brand-50/50 font-semibold text-ink-800 hover:border-brand-400'
                                                                : 'border-ink-100 bg-white font-semibold text-ink-700 hover:border-brand-300'}`}>
                                                    <CountryFlag iso={m.iso_code} className="h-3.5 w-5 rounded-[2px]" iconClass="h-3.5 w-3.5 text-ink-400" />
                                                    {m.name}
                                                    {m.products.length > 0 && <span className="ml-auto text-xs font-semibold text-ink-400">{m.products.length}</span>}
                                                </button>
                                            </li>
                                        );
                                    })}
                                </ul>
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Export footprint */}
            <section className="bg-ink-950 py-16 text-white sm:py-20">
                <Container>
                    <div className="mx-auto max-w-2xl text-center">
                        <p className="mb-3 flex items-center justify-center gap-2.5 text-xs font-semibold uppercase tracking-[0.04em] text-brand-300">
                            <span className="h-px w-6 bg-brand-400" aria-hidden />{content.footprint_eyebrow}<span className="h-px w-6 bg-brand-400" aria-hidden />
                        </p>
                        <h2 className="t-h2">{content.footprint_title}</h2>
                        <p className="mt-4 leading-relaxed text-ink-200">{content.footprint_body}</p>
                    </div>
                    <div className="mx-auto mt-10 grid max-w-4xl grid-cols-2 gap-4 lg:grid-cols-4">
                        {content.footprint_stats.map((s) => (
                            <div key={s.label} className="rounded-2xl border border-ink-800 bg-ink-900/60 p-5">
                                <Stat value={s.value} label={s.label} />
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* International offices */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.offices_eyebrow} title={content.offices_title} />
                    <div className="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {offices.map((o) => (
                            <address key={o.name} className="rounded-2xl border border-ink-100 bg-white p-6 not-italic shadow-card">
                                <h3 className="flex items-start gap-2 t-h4 text-ink-900">
                                    <Building2 size={17} className="mt-0.5 shrink-0 text-brand-700" aria-hidden />{o.name}
                                </h3>
                                <p className="mt-3 text-sm leading-relaxed text-ink-600">{o.address}</p>
                                <p className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-800">
                                    <Phone size={14} className="text-brand-600" aria-hidden />{o.phone}
                                    {o.phone_alt && <span className="text-ink-500">· {o.phone_alt}</span>}
                                </p>
                                <a href={`mailto:${o.email}`} className="mt-1.5 flex items-center gap-2 text-sm font-semibold text-brand-700 hover:underline">
                                    <Mail size={14} aria-hidden />{o.email}
                                </a>
                            </address>
                        ))}
                    </div>
                    <div className="group relative mt-12 overflow-hidden rounded-2xl bg-gradient-to-br from-brand-700 via-brand-800 to-ink-950 p-8 text-center text-white sm:p-12">
                        <div className="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10 transition-transform duration-700 group-hover:scale-110" aria-hidden />
                        <div className="absolute -bottom-24 -left-16 h-56 w-56 rounded-full border border-white/10 transition-transform duration-700 group-hover:scale-110" aria-hidden />
                        <div className="absolute inset-0 bg-[radial-gradient(50%_70%_at_50%_0%,rgba(255,255,255,0.10),transparent)]" aria-hidden />
                        <div className="relative">
                            <span className="mx-auto flex h-12 w-12 items-center justify-center rounded-full border border-white/15 bg-white/10 text-brand-200 backdrop-blur-sm">
                                <Handshake size={22} aria-hidden />
                            </span>
                            <h2 className="mt-4 t-h3">{content.cta_title}</h2>
                            <p className="mx-auto mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                                {content.cta_body}
                            </p>
                            <div className="mt-6 flex flex-wrap items-center justify-center gap-3">
                                <ButtonLink href="/contact" variant="light">
                                    {content.cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden />
                                </ButtonLink>
                                {site.whatsapp && (
                                    <ButtonLink href={`https://wa.me/${site.whatsapp}`} variant="outlineLight" external target="_blank" rel="noopener noreferrer">
                                        <WhatsAppIcon size={15} /> {content.cta_alt_label}
                                    </ButtonLink>
                                )}
                            </div>
                        </div>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
