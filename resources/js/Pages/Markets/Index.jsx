import { Link } from "@inertiajs/react";
import { ArrowRight, Building2, Mail, MapPin, Phone } from 'lucide-react';
import { ButtonLink, Container, PageHero, SectionHeading } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function MarketsIndex({ seo, markets, offices }) {
    const withPages = markets.filter((m) => m.has_page);
    const listed = markets.filter((m) => !m.has_page);

    return (
        <SiteLayout>
            <PageHero eyebrow="Global Presence" breadcrumbs={[['Home', '/'], ['Global Presence']]}
                title="Healthcare products to 24+ countries — and counting"
                lead="From the South Pacific to West Africa to Central America: through every step, our commitment is to deliver quality, efficacious products and leave a positive footprint wherever we go." />

            {/* Featured markets with dedicated pages */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="Key Markets" title="Where we operate directly" />
                    <div className="mt-10 grid gap-5 md:grid-cols-3">
                        {withPages.map((m) => (
                            <a key={m.slug} href={`/global-presence/${m.slug}`}
                               className="group flex h-full flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-all hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover">
                                <div className="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-brand-700">
                                    <MapPin size={13} aria-hidden /> {m.region}
                                </div>
                                <h3 className="mt-2 text-xl font-extrabold text-ink-900 group-hover:text-brand-800">{m.name}</h3>
                                <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{m.description}</p>
                                <span className="mt-4 inline-flex items-center gap-1 text-sm font-bold text-brand-700">
                                    Explore market <ArrowRight size={14} aria-hidden className="transition-transform group-hover:translate-x-0.5" />
                                </span>
                            </a>
                        ))}
                    </div>
                </Container>
            </section>

            {/* All markets */}
            <section className="bg-ink-950 py-16 text-white sm:py-20">
                <Container>
                    <div className="grid items-center gap-10 lg:grid-cols-[1fr_1.2fr]">
                        <div>
                            <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">Export Footprint</p>
                            <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">Every container tells a story</h2>
                            <p className="mt-4 leading-relaxed text-ink-200">
                                More than 200 containers shipped in FY 2023–24. Below are the markets we serve —
                                and the number keeps growing.
                            </p>
                        </div>
                        <ul className="grid grid-cols-2 gap-3 sm:grid-cols-3">
                            {markets.map((m) => (
                                <li key={m.slug}>
                                    {m.has_page ? (
                                        <Link href={`/global-presence/${m.slug}`}
                                           className="flex items-center gap-2 rounded-xl border border-brand-500/40 bg-brand-900/40 px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-brand-800">
                                            <MapPin size={14} className="shrink-0 text-brand-300" aria-hidden />{m.name}
                                        </Link>
                                    ) : (
                                        <span className="flex items-center gap-2 rounded-xl border border-ink-700 bg-ink-900 px-4 py-3 text-sm font-semibold text-ink-200">
                                            <MapPin size={14} className="shrink-0 text-ink-500" aria-hidden />{m.name}
                                        </span>
                                    )}
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
                    <SectionHeading eyebrow="On the Ground" title="International offices & partners" />
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
                        <h2 className="text-xl font-extrabold">Don't see your market?</h2>
                        <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                            We open new markets with the right partners. If you distribute pharmaceuticals or
                            manage public health procurement, let's discuss your territory.
                        </p>
                        <ButtonLink href="/contact" variant="light" className="mt-5">Start the conversation</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
