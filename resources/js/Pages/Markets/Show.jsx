import { Building2, Mail, MapPin, Phone } from 'lucide-react';
import { ProductCard } from '../../Components/Cards';
import { ButtonLink, Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function MarketsShow({ seo, market, office, products }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={market.region || 'Global Presence'}
                breadcrumbs={[['Home', '/'], ['Global Presence', '/global-presence'], [market.name]]}
                title={`Pharmaceutical supply to ${market.name}`}
                lead={market.description} />

            <section className="py-14 sm:py-20">
                <Container className="grid gap-12 lg:grid-cols-[1fr_320px]">
                    <div>
                        {products.length > 0 && (
                            <>
                                <h2 className="text-2xl font-extrabold tracking-tight text-ink-900">
                                    Nymak products in {market.name}
                                </h2>
                                <p className="mt-2 text-sm text-ink-600">
                                    Branded formulations registered and supplied for the {market.name} market.
                                </p>
                                <div className="mt-8 grid grid-cols-2 gap-5 md:grid-cols-3">
                                    {products.map((p) => <ProductCard key={p.url} product={p} url={p.url} />)}
                                </div>
                            </>
                        )}

                        <div className="prose-nymak mt-12 max-w-3xl">
                            <h2>Working with Nymak in {market.name}</h2>
                            <p>
                                Nymak Pharma supplies {market.name} with WHO-GMP certified pharmaceuticals
                                manufactured at our facility in Mundra, Gujarat, India. Our in-house regulatory
                                team supports product registration, dossiers and market-specific labelling for
                                the {market.name} market.
                            </p>
                            <p>
                                Importers, distributors, hospitals and public health programmes in {market.name}
                                can contact our exports team for pricing, pack configurations and registration
                                support.
                            </p>
                        </div>
                    </div>

                    <aside className="lg:sticky lg:top-28 lg:self-start">
                        {office && (
                            <address className="rounded-2xl border border-ink-100 bg-white p-6 not-italic shadow-card">
                                <h3 className="flex items-start gap-2 text-base font-bold text-ink-900">
                                    <Building2 size={17} className="mt-0.5 shrink-0 text-brand-700" aria-hidden />
                                    {office.name}
                                </h3>
                                <p className="mt-3 text-sm leading-relaxed text-ink-600">{office.address}</p>
                                <p className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-800">
                                    <Phone size={14} className="text-brand-600" aria-hidden />{office.phone}
                                </p>
                                {office.phone_alt && (
                                    <p className="mt-1 flex items-center gap-2 text-sm text-ink-600">
                                        <span className="w-3.5" />{office.phone_alt}
                                    </p>
                                )}
                                <a href={`mailto:${office.email}`} className="mt-1.5 flex items-center gap-2 text-sm font-semibold text-brand-700 hover:underline">
                                    <Mail size={14} aria-hidden />{office.email}
                                </a>
                            </address>
                        )}
                        <div className="mt-5 rounded-2xl bg-brand-700 p-6 text-white">
                            <h3 className="text-base font-extrabold">Enquiries for {market.name}</h3>
                            <p className="mt-2 text-sm leading-relaxed text-brand-100">
                                Distribution, tenders and registration questions — our team responds to every enquiry.
                            </p>
                            <ButtonLink href="/contact" variant="light" className="mt-4 w-full">Contact us</ButtonLink>
                        </div>
                    </aside>
                </Container>
            </section>
        </SiteLayout>
    );
}
