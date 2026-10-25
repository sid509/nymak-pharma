import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFileLines, faShieldHalved } from '@fortawesome/free-solid-svg-icons';

import Accordion from '../Components/Accordion';
import { useT } from '../i18n/useT';
import { Container, GhostTitle, PageHero } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Quality({ seo, certifications, faqs, content }) {
    const { t } = useT();
    const certScans = [
        { image: content.cert_iso_image, label: t('ISO 13485:2016 Certificate') },
        { image: content.cert_star_image, label: t('Star Export House Certificate of Recognition') },
    ].filter((c) => c.image);

    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Quality & Certifications']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Certifications grid */}
            <section className="py-16 sm:py-20">
                <Container>
                    <div className="mx-auto max-w-3xl text-center">
                        <p className="mb-3 flex items-center justify-center gap-2.5 t-eyebrow text-gold-700">
                            <span className="h-px w-6 bg-gold-400" aria-hidden />{content.cred_eyebrow}<span className="h-px w-6 bg-gold-400" aria-hidden />
                        </p>
                        <GhostTitle title={content.cred_title} />
                        <p className="mt-4 t-lead text-pretty text-ink-600">{content.cred_lead}</p>
                    </div>
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {certifications.map((c) => (
                            <article key={c.name} className="card-hover flex flex-col rounded-2xl border border-ink-100 bg-white p-7 shadow-card">
                                <div className="flex h-28 items-center justify-center rounded-xl bg-ink-50 p-4">
                                    {c.image ? (
                                        <img src={`/${c.image}`} alt={`${c.name} certificate logo`} width="160" height="96" loading="lazy"
                                             className="max-h-24 w-auto object-contain" />
                                    ) : (
                                        <FontAwesomeIcon style={{ fontSize: 44 }} icon={faShieldHalved} className="text-brand-600" aria-hidden />
                                    )}
                                </div>
                                <h3 className="mt-5 t-h4 text-ink-900">{c.name}</h3>
                                {c.issuer && <p className="mt-1 text-[13px] font-semibold uppercase tracking-[0.04em] text-brand-700">{c.issuer}</p>}
                                {c.description && <p className="mt-2 flex-1 text-[0.9375rem] leading-relaxed text-ink-600">{c.description}</p>}
                            </article>
                        ))}
                    </div>

                    {/* Certificate documents */}
                    {certScans.length > 0 && (
                        <div className="mt-12 grid gap-5 sm:grid-cols-2">
                            {certScans.map((c) => (
                                <figure key={c.label} className="card-hover rounded-2xl border border-ink-100 bg-white p-4 shadow-card">
                                    <img src={`/${c.image}`} alt={`${c.label}, Nymak Pharma`}
                                         width="1200" height="1600" loading="lazy"
                                         className="w-full rounded-xl border border-ink-100 object-contain" />
                                    <figcaption className="mt-3 flex items-center gap-2 text-sm font-semibold text-ink-700">
                                        <FontAwesomeIcon style={{ fontSize: 15 }} icon={faFileLines} className="text-brand-600" aria-hidden /> {c.label}
                                    </figcaption>
                                </figure>
                            ))}
                        </div>
                    )}
                </Container>
            </section>

            {/* Quality system */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <div className="mx-auto mb-12 max-w-2xl text-center">
                        <GhostTitle title={content.system_title} />
                    </div>
                    <div className="grid gap-10 lg:grid-cols-2">
                    <div>
                        <div className="prose-nymak">
                            <p>{content.system_p1}</p>
                            <p>{content.system_p2}</p>
                            <p>{content.system_p3}</p>
                        </div>
                    </div>
                    {faqs?.length > 0 && (
                        <div>
                            <h3 className="mb-5 t-h3 text-ink-900">{content.faq_title}</h3>
                            <Accordion items={faqs} />
                        </div>
                    )}
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
