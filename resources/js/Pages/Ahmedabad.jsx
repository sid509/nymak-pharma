import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowRight, faBuilding, faEnvelope, faIndustry, faPhone } from '@fortawesome/free-solid-svg-icons';

import { Reveal } from '../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

/**
 * Ahmedabad / Gujarat landing page - the corporate office, the Gujarat pharma
 * ecosystem around it, and how the works at Mundra connects. Copy is fully
 * admin-managed via the 'ahmedabad' content page (editable in admin content).
 */
export default function Ahmedabad({ seo, offices, content: c }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={c.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Ahmedabad, Gujarat']]}
                title={c.hero_title}
                lead={c.hero_lead} />

            {/* Corporate office */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={c.hero_eyebrow} title={c.overview_title} />
                    <div className="mt-6 grid gap-10 lg:grid-cols-[minmax(0,1.4fr)_minmax(20rem,1fr)]">
                        <div className="prose-nymak">
                            {c.overview_p1 && <p>{c.overview_p1}</p>}
                            {c.overview_p2 && <p>{c.overview_p2}</p>}
                        </div>
                        {offices.length > 0 && (
                            <div className="space-y-4">
                                <h3 className="t-h4 text-ink-900">{c.office_title}</h3>
                                {offices.map((o) => (
                                    <address key={o.name} className="card-hover rounded-2xl border border-ink-100 bg-white p-5 not-italic shadow-card">
                                        <h4 className="flex items-center gap-2 text-sm font-semibold text-ink-900">
                                            <FontAwesomeIcon style={{ fontSize: 15 }} icon={faBuilding} className="text-brand-700" aria-hidden />{o.name}
                                        </h4>
                                        <p className="mt-2 text-sm leading-relaxed text-ink-600">{o.address}</p>
                                        <p className="mt-2 flex items-center gap-2 text-sm font-semibold text-ink-800">
                                            <FontAwesomeIcon style={{ fontSize: 13 }} icon={faPhone} className="text-brand-600" aria-hidden />{o.phone}
                                        </p>
                                        <a href={`mailto:${o.email}`} className="mt-1 flex items-center gap-2 text-sm font-semibold text-brand-700 hover:underline">
                                            <FontAwesomeIcon style={{ fontSize: 13 }} icon={faEnvelope} aria-hidden />{o.email}
                                        </a>
                                    </address>
                                ))}
                            </div>
                        )}
                    </div>
                </Container>
            </section>

            {/* Why Gujarat */}
            <section className="border-t border-ink-100 bg-ink-50/50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={c.hero_eyebrow} title={c.why_title} />
                    <div className="prose-nymak mt-6 max-w-3xl">
                        {c.why_p1 && <p>{c.why_p1}</p>}
                        {c.why_p2 && <p>{c.why_p2}</p>}
                    </div>
                </Container>
            </section>

            {/* Works connection */}
            <section className="py-16 sm:py-20">
                <Container>
                    <div className="grid items-center gap-10 lg:grid-cols-2">
                        <Reveal>
                            <div className="relative overflow-hidden rounded-2xl shadow-card">
                                <img src="/images/hero/facility-aerial.webp" alt="Nymak Pharma works at Mundra, Gujarat"
                                     width="960" height="640" loading="lazy" className="w-full object-cover" />
                                <div className="absolute bottom-4 left-4 rounded-xl bg-white/95 px-4 py-2 text-xs font-bold uppercase tracking-wider text-ink-700 shadow-card">
                                    <FontAwesomeIcon style={{ fontSize: 12 }} icon={faIndustry} className="mr-1.5 text-brand-700" aria-hidden />Head Office &amp; Works, Mundra
                                </div>
                            </div>
                        </Reveal>
                        <div>
                            <SectionHeading eyebrow={c.hero_eyebrow} title={c.works_title} align="left" />
                            <div className="prose-nymak mt-4">
                                {c.works_p1 && <p>{c.works_p1}</p>}
                                {c.works_p2 && <p>{c.works_p2}</p>}
                            </div>
                            <ButtonLink href="/manufacturing" variant="outline" className="mt-6">
                                See the facility <FontAwesomeIcon style={{ fontSize: 15 }} icon={faArrowRight} className="btn-arrow" aria-hidden />
                            </ButtonLink>
                        </div>
                    </div>
                </Container>
            </section>

            {/* CTA */}
            <section className="border-t border-ink-100 bg-gradient-to-br from-brand-800 via-brand-900 to-ink-950 py-16 sm:py-20">
                <Container>
                    <div className="mx-auto max-w-2xl text-center">
                        <h2 className="t-h2 text-white">{c.cta_title}</h2>
                        <p className="mt-4 leading-relaxed text-ink-200">{c.cta_body}</p>
                        <ButtonLink href="/contact" variant="light" className="mt-8">Contact us <FontAwesomeIcon style={{ fontSize: 15 }} icon={faArrowRight} className="btn-arrow" aria-hidden /></ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
