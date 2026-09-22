import { FileText, ShieldCheck } from 'lucide-react';
import Accordion from '../Components/Accordion';
import { Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Quality({ seo, certifications, faqs, content }) {
    const certScans = [
        { image: content.cert_iso_image, label: 'ISO 13485:2016 Certificate' },
        { image: content.cert_star_image, label: 'Star Export House Certificate of Recognition' },
    ].filter((c) => c.image);

    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Quality & Certifications']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Certifications grid */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.cred_eyebrow} title={content.cred_title}
                        lead={content.cred_lead} />
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
                    {certScans.length > 0 && (
                        <div className="mt-12 grid gap-5 sm:grid-cols-2">
                            {certScans.map((c) => (
                                <figure key={c.label} className="rounded-2xl border border-ink-100 bg-white p-4 shadow-card">
                                    <img src={`/${c.image}`} alt={`${c.label} — Nymak Pharma`}
                                         width="1200" height="1600" loading="lazy"
                                         className="w-full rounded-xl border border-ink-100 object-contain" />
                                    <figcaption className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-700">
                                        <FileText size={15} className="text-brand-600" aria-hidden /> {c.label}
                                    </figcaption>
                                </figure>
                            ))}
                        </div>
                    )}
                </Container>
            </section>

            {/* Quality system */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container className="grid gap-10 lg:grid-cols-2">
                    <div className="prose-nymak">
                        <h2>{content.system_title}</h2>
                        <p>{content.system_p1}</p>
                        <p>{content.system_p2}</p>
                        <p>{content.system_p3}</p>
                    </div>
                    {faqs?.length > 0 && (
                        <div>
                            <h3 className="mb-5 text-xl font-extrabold text-ink-900">{content.faq_title}</h3>
                            <Accordion items={faqs} />
                        </div>
                    )}
                </Container>
            </section>
        </SiteLayout>
    );
}
