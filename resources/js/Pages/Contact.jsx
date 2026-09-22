import { usePage } from '@inertiajs/react';
import { Building2, Clock, Download, Mail, MapPin, MessageCircle, Phone } from 'lucide-react';
import EnquiryForm from '../Components/EnquiryForm';
import { Container, PageHero } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Contact({ seo, offices, products, selectedProduct, formStartedAt, honeypot, content }) {
    const { site, flash } = usePage().props;

    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Contact Us']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            <section className="py-14 sm:py-20">
                <Container className="grid gap-12 lg:grid-cols-[1fr_420px]">
                    {/* Form */}
                    <div>
                        {flash?.success && (
                            <div role="status" className="mb-6 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm font-semibold text-brand-900">
                                {flash.success}
                            </div>
                        )}
                        <div className="rounded-2xl border border-ink-100 bg-white p-6 shadow-card sm:p-8">
                            <h2 className="text-xl font-extrabold text-ink-900">{content.form_title}</h2>
                            <p className="mt-1 text-sm text-ink-500">{content.form_lead}</p>
                            <div className="mt-6">
                                <EnquiryForm products={products} selectedProduct={selectedProduct} formStartedAt={formStartedAt} honeypot={honeypot} />
                            </div>
                        </div>
                    </div>

                    {/* Contact details — consistent NAP */}
                    <aside className="space-y-5 lg:sticky lg:top-28 lg:self-start">
                        <div className="rounded-2xl bg-ink-950 p-6 text-white">
                            <h2 className="text-base font-extrabold">Head Office & Works</h2>
                            <address className="mt-4 space-y-3 text-sm not-italic">
                                <p className="flex gap-2.5">
                                    <MapPin size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />
                                    <span className="text-ink-200">
                                        {site.address.street}, {site.address.city}, {site.address.region} — {site.address.postal_code}, {site.address.country}
                                    </span>
                                </p>
                                <p className="flex gap-2.5 text-ink-200">
                                    <MapPin size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />
                                    <span>Branch: {site.branch_address}</span>
                                </p>
                                <p>
                                    <a href={`tel:${site.phone_href}`} className="flex gap-2.5 font-semibold hover:text-white">
                                        <Phone size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />{site.phone}
                                    </a>
                                </p>
                                <p>
                                    <a href={`mailto:${site.email}`} className="flex gap-2.5 font-semibold hover:text-white">
                                        <Mail size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />{site.email}
                                    </a>
                                </p>
                                <p className="flex gap-2.5 text-ink-200">
                                    <Clock size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />
                                    <span>Mon–Sat, 9:30–18:30 IST</span>
                                </p>
                            </address>
                            <div className="mt-5 flex flex-col gap-2.5 border-t border-ink-800 pt-5">
                                <a href={`https://wa.me/${site.whatsapp}`} target="_blank" rel="noopener noreferrer"
                                   onClick={() => window.nymakTrack && window.nymakTrack('contact_click', { method: 'whatsapp' })}
                                   className="inline-flex items-center gap-2 text-sm font-bold text-brand-300 hover:text-white">
                                    <MessageCircle size={16} aria-hidden /> Chat on WhatsApp
                                </a>
                                <a href="/nymak-pharma-brochure.pdf" target="_blank" rel="noopener noreferrer"
                                   onClick={() => window.nymakTrack && window.nymakTrack('brochure_download')}
                                   className="inline-flex items-center gap-2 text-sm font-bold text-brand-300 hover:text-white">
                                    <Download size={16} aria-hidden /> Download product brochure (PDF)
                                </a>
                            </div>
                        </div>

                        {offices.map((o) => (
                            <address key={o.name} className="rounded-2xl border border-ink-100 bg-white p-5 not-italic shadow-card">
                                <h3 className="flex items-center gap-2 text-sm font-bold text-ink-900">
                                    <Building2 size={15} className="text-brand-700" aria-hidden />{o.name}
                                </h3>
                                <p className="mt-2 text-sm leading-relaxed text-ink-600">{o.address}</p>
                                <p className="mt-2 text-sm font-semibold text-ink-800">{o.phone}{o.phone_alt ? ` · ${o.phone_alt}` : ''}</p>
                                <a href={`mailto:${o.email}`} className="text-sm font-semibold text-brand-700 hover:underline">{o.email}</a>
                            </address>
                        ))}
                    </aside>
                </Container>
            </section>
        </SiteLayout>
    );
}
