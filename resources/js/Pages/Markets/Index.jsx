import { Link } from "@inertiajs/react";
import { ArrowRight, Building2, Mail, MapPin, Package, Phone } from 'lucide-react';
import { useState } from 'react';
import Markdown from '../../Components/Markdown';
import { Reveal } from '../../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

/** One portfolio entry: the market, what we did there, and what we supply. */
function PortfolioEntry({ m, open, onToggle }) {
    return (
        <article className="overflow-hidden rounded-2xl border border-ink-100 bg-white shadow-card">
            <button type="button" onClick={onToggle} aria-expanded={open}
                    className="flex w-full items-start justify-between gap-4 p-6 text-left transition-colors hover:bg-brand-50/40">
                <span>
                    <span className="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-brand-700">
                        <MapPin size={13} aria-hidden /> {m.region}
                        {m.office && <span className="rounded-full bg-gold-100 px-2 py-0.5 text-[10px] font-bold text-gold-800">Local office</span>}
                    </span>
                    <h3 className="mt-2 text-xl font-extrabold text-ink-900">{m.name}</h3>
                    {m.description && (
                        <div className={`mt-2 text-sm leading-relaxed text-ink-600 ${open ? '' : 'line-clamp-2'}`}>
                            <Markdown text={m.description} inline />
                        </div>
                    )}
                </span>
                <span className="mt-1 shrink-0 text-xs font-bold text-brand-700">
                    {open ? 'Less ↑' : `${m.products.length} product${m.products.length === 1 ? '' : 's'} ↓`}
                </span>
            </button>

            <div className={`grid transition-[grid-template-rows] duration-300 ease-out ${open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'}`}>
                <div className="overflow-hidden">
                    {m.products.length > 0 && (
                        <div className="border-t border-ink-100 bg-ink-50/40 px-6 py-5">
                            <p className="mb-3 flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-ink-500">
                                <Package size={12} aria-hidden /> Supplied to {m.name}
                            </p>
                            <ul className="flex flex-wrap gap-2">
                                {m.products.map((p) => (
                                    <li key={p.url}>
                                        <Link href={p.url}
                                              className="inline-flex items-center gap-1.5 rounded-full border border-ink-200 bg-white px-3 py-1.5 text-xs font-semibold text-ink-700 transition-colors hover:border-brand-300 hover:text-brand-800">
                                            {p.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                    {m.office && (
                        <address className="border-t border-ink-100 px-6 py-4 text-sm not-italic text-ink-600">
                            <span className="font-bold text-ink-800">{m.office.name}:</span> {m.office.address} · {m.office.phone}
                        </address>
                    )}
                </div>
            </div>
        </article>
    );
}

export default function MarketsIndex({ seo, markets, portfolio, offices, content }) {
    const [openSlug, setOpenSlug] = useState(portfolio[0]?.slug ?? null);
    const portfolioSlugs = new Set(portfolio.map((m) => m.slug));

    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Global Presence']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Market portfolio — what we've done where, expandable per country */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.markets_eyebrow} title={content.markets_title} />
                    <div className="mt-10 space-y-4">
                        {portfolio.map((m, i) => (
                            <Reveal key={m.slug} delay={Math.min(i * 40, 160)}>
                                <PortfolioEntry m={m} open={openSlug === m.slug}
                                                onToggle={() => setOpenSlug(openSlug === m.slug ? null : m.slug)} />
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Full export footprint */}
            <section className="bg-ink-950 py-16 text-white sm:py-20">
                <Container>
                    <div className="grid items-center gap-10 lg:grid-cols-[1fr_1.2fr]">
                        <div>
                            <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">{content.footprint_eyebrow}</p>
                            <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">{content.footprint_title}</h2>
                            <p className="mt-4 leading-relaxed text-ink-200">
                                {content.footprint_body}
                            </p>
                        </div>
                        <ul className="grid grid-cols-2 gap-3 sm:grid-cols-3">
                            {markets.map((m) => (
                                <li key={m.slug}>
                                    <button type="button"
                                            onClick={() => portfolioSlugs.has(m.slug) && setOpenSlug(m.slug)}
                                            className={`flex w-full items-center gap-2 rounded-xl border px-4 py-3 text-sm transition-colors ${
                                                portfolioSlugs.has(m.slug)
                                                    ? 'border-brand-500/40 bg-brand-900/40 font-bold text-white hover:bg-brand-800'
                                                    : 'border-ink-700 bg-ink-900 font-semibold text-ink-200'}`}>
                                        <MapPin size={14} className={`shrink-0 ${portfolioSlugs.has(m.slug) ? 'text-brand-300' : 'text-ink-500'}`} aria-hidden />{m.name}
                                    </button>
                                </li>
                            ))}
                            <li>
                                <span className="flex items-center gap-2 rounded-xl border border-dashed border-ink-600 px-4 py-3 text-sm font-bold text-brand-300">
                                    + more countries
                                </span>
                            </li>
                        </ul>
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
                                <h3 className="flex items-start gap-2 text-base font-bold text-ink-900">
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
                    <div className="mt-12 rounded-2xl bg-brand-700 p-8 text-white">
                        <h2 className="text-xl font-extrabold">{content.cta_title}</h2>
                        <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                            {content.cta_body}
                        </p>
                        <ButtonLink href="/contact" variant="light" className="mt-5">Start the conversation <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
