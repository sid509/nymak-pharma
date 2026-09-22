import { FileText, ShieldCheck } from 'lucide-react';
import Accordion from '../Components/Accordion';
import { Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Quality({ seo, certifications, faqs }) {
    return (
        <SiteLayout>
            <PageHero eyebrow="Quality & Certifications" breadcrumbs={[['Home', '/'], ['Quality & Certifications']]}
                title="Certified quality, verifiable compliance"
                lead="Every accolade reflects our commitment to quality, integrity and the partners who rely on our products — WHO-GMP, ISO 13485:2016, Star Export House and more." />

            {/* Certifications grid */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="Credentials" title="Awards & certifications"
                        lead="Certificates are available to partners for verification during registration and audits." />
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {certifications.map((c) => (
                            <article key={c.name} className="flex flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <div className="flex h-20 items-center justify-center rounded-xl bg-ink-50 p-3">
                                    {c.image ? (
                                        <img src={`/${c.image}`} alt={`${c.name} certificate logo`} width="140" height="80" loading="lazy"
                                             className="max-h-16 w-auto object-contain" />
                                    ) : (
                                        <ShieldCheck size={36} className="text-brand-600" aria-hidden />
                                    )}
                                </div>
                                <h3 className="mt-4 text-base font-bold text-ink-900">{c.name}</h3>
                                {c.issuer && <p className="text-xs font-semibold uppercase tracking-wider text-brand-700">{c.issuer}</p>}
                                {c.description && <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{c.description}</p>}
                            </article>
                        ))}
                    </div>

                    {/* Certificate documents */}
                    <div className="mt-12 grid gap-5 sm:grid-cols-2">
                        <figure className="rounded-2xl border border-ink-100 bg-white p-4 shadow-card">
                            <img src="/images/certifications/iso-13485-certificate.webp" alt="ISO 13485:2016 certificate issued to Nymak Pharma"
                                 width="1200" height="1600" loading="lazy"
                                 className="w-full rounded-xl border border-ink-100 object-contain" />
                            <figcaption className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-700">
                                <FileText size={15} className="text-brand-600" aria-hidden /> ISO 13485:2016 Certificate
                            </figcaption>
                        </figure>
                        <figure className="rounded-2xl border border-ink-100 bg-white p-4 shadow-card">
                            <img src="/images/certifications/star-export-house-certificate.webp" alt="Star Export House certificate of recognition — Nymak Pharma"
                                 width="1200" height="1600" loading="lazy"
                                 className="w-full rounded-xl border border-ink-100 object-contain" />
                            <figcaption className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-700">
                                <FileText size={15} className="text-brand-600" aria-hidden /> Star Export House Certificate of Recognition
                            </figcaption>
                        </figure>
                    </div>
                </Container>
            </section>

            {/* Quality system */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container className="grid gap-10 lg:grid-cols-2">
                    <div className="prose-nymak">
                        <h2>How quality works here</h2>
                        <p>
                            Quality at Nymak is not a department — it is the sequence every product passes
                            through. Raw materials are controlled on entry, production follows documented
                            GMP processes, batch lots are analysed by the in-house QC laboratory, and a
                            separate QA function reviews each release before dispatch.
                        </p>
                        <p>
                            Around production sits the supporting structure: a regulatory team preparing
                            dossiers for destination-market registration, a design team producing compliant
                            labelling, and warehouse teams maintaining controlled storage through to shipment.
                        </p>
                        <p>
                            This is what partners verify when they audit us — and what the WHO-GMP, ISO 13485
                            and Star Export House credentials certify from the outside.
                        </p>
                    </div>
                    {faqs?.length > 0 && (
                        <div>
                            <h3 className="mb-5 text-xl font-extrabold text-ink-900">Quality questions</h3>
                            <Accordion items={faqs} />
                        </div>
                    )}
                </Container>
            </section>
        </SiteLayout>
    );
}
