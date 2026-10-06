import { ClipboardCheck, FileCheck2, FlaskConical, Microscope, Package, Warehouse } from 'lucide-react';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const ICONS = { ClipboardCheck, FileCheck2, FlaskConical, Microscope, Package, Warehouse };
const Icon = ({ name }) => {
    const C = ICONS[name] || FlaskConical;
    return <C size={20} aria-hidden />;
};

export default function Manufacturing({ seo, content }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Manufacturing']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Facility overview */}
            <section className="py-16 sm:py-20">
                <Container>
                    <h2 className="mx-auto mb-10 max-w-2xl text-center t-h2 text-balance text-ink-900">{content.overview_title}</h2>
                    <div className="grid items-start gap-10 lg:grid-cols-2">
                    <div>
                        <div className="prose-nymak">
                            <p>{content.overview_p1}</p>
                            <p>{content.overview_p2}</p>
                            <p>{content.overview_p3}</p>
                        </div>
                    </div>
                    <div className="lg:sticky lg:top-28">
                        <img src={`/${content.facility_image}`} alt="Nymak Pharma manufacturing facility, Port Biz Industrial Park, Mundra"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="mt-4 grid grid-cols-2 gap-3">
                            <div className="rounded-xl bg-brand-50 p-4">
                                <p className="text-2xl font-bold text-brand-800">WHO-GMP</p>
                                <p className="text-xs font-semibold text-ink-600">Certified facility</p>
                            </div>
                            <div className="rounded-xl bg-brand-50 p-4">
                                <p className="text-2xl font-bold text-brand-800">ISO 13485</p>
                                <p className="text-xs font-semibold text-ink-600">Quality management</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </Container>
            </section>

            {/* Capabilities grid */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.capabilities_eyebrow} title={content.capabilities_title} align="center"
                        lead={content.capabilities_lead} />
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {(content.capabilities || []).map((c) => (
                            <div key={c.title} className="rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <span className="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                    <Icon name={c.icon} />
                                </span>
                                <h3 className="mt-4 t-h4 text-ink-900">{c.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-ink-600">{c.text}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Dosage forms */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.dosage_eyebrow} title={content.dosage_title} />
                    <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {(content.dosage_forms || []).map((d) => (
                            <div key={d.title} className="rounded-xl border border-ink-100 bg-white p-5 shadow-card">
                                <h3 className="text-sm font-semibold text-ink-900">{d.title}</h3>
                                <p className="mt-1.5 text-sm leading-relaxed text-ink-600">{d.text}</p>
                            </div>
                        ))}
                    </div>
                    <div className="mt-12 flex flex-wrap gap-3">
                        <ButtonLink href="/products">Browse the product catalogue</ButtonLink>
                        <ButtonLink href="/quality-certifications" variant="outline">Quality & certifications</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
