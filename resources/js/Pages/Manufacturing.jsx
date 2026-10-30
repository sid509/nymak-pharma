import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBox, faCircleCheck, faClipboardCheck, faFileCircleCheck, faFlask, faLocationDot, faMicroscope, faShip, faWarehouse } from '@fortawesome/free-solid-svg-icons';

import { Reveal } from '../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';
import { useT } from '../i18n/useT';

const ICONS = { faClipboardCheck, faFileCircleCheck, faFlask, faMicroscope, faBox, faWarehouse };
const Icon = ({ name, size = 20 }) => (
    <FontAwesomeIcon icon={ICONS[name] || faFlask} style={{ fontSize: size }} aria-hidden />
);

export default function Manufacturing({ seo, content }) {
    const { t } = useT();
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Manufacturing']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Facility overview - copy beside a rich Mundra fact panel */}
            <section className="py-16 sm:py-20">
                <Container>
                    <h2 className="mx-auto mb-10 max-w-2xl text-center t-h2 text-balance text-ink-950">{content.overview_title}</h2>
                    <div className="grid items-start gap-10 lg:grid-cols-2">
                    <div>
                        <div className="prose-nymak">
                            <p>{content.overview_p1}</p>
                            <p>{content.overview_p2}</p>
                            <p>{content.overview_p3}</p>
                        </div>
                    </div>
                    <div className="lg:sticky lg:top-28">
                        <Reveal variant="media" className="rounded-2xl shadow-card">
                            <img src={`/${content.facility_image}`} alt="Drug manufacturing companies in India: Nymak Pharma facility, Port Biz Industrial Park, Mundra"
                                 width="960" height="640" loading="lazy"
                                 className="w-full object-cover" />
                        </Reveal>
                        {/* Mundra fact panel - certifications, logistics and location
                            in one dark card so the column carries its weight. */}
                        <div className="relative mt-5 overflow-hidden rounded-2xl bg-gradient-to-br from-brand-800 via-brand-900 to-ink-950 p-6 text-white shadow-card sm:p-7">
                            <div className="absolute -right-14 -top-14 h-44 w-44 rounded-full border border-white/10" aria-hidden />
                            <div className="absolute -bottom-16 -left-10 h-36 w-36 rounded-full border border-white/10" aria-hidden />
                            <p className="relative flex items-center gap-2 t-eyebrow text-brand-300">
                                <FontAwesomeIcon style={{ fontSize: 14 }} icon={faLocationDot} aria-hidden /> {t('Mundra · Gujarat · India')}
                            </p>
                            <div className="relative mt-5 grid grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <p className="flex items-center gap-2 text-lg font-bold"><FontAwesomeIcon style={{ fontSize: 18 }} icon={faCircleCheck} className="text-brand-300" aria-hidden />WHO-GMP</p>
                                    <p className="mt-1 text-[13px] font-medium text-ink-200">{t('Certified facility')}</p>
                                </div>
                                <div>
                                    <p className="flex items-center gap-2 text-lg font-bold"><FontAwesomeIcon style={{ fontSize: 18 }} icon={faCircleCheck} className="text-brand-300" aria-hidden />ISO 13485</p>
                                    <p className="mt-1 text-[13px] font-medium text-ink-200">{t('Quality management')}</p>
                                </div>
                                <div>
                                    <p className="flex items-center gap-2 text-lg font-bold"><FontAwesomeIcon style={{ fontSize: 18 }} icon={faShip} className="text-brand-300" aria-hidden />200+</p>
                                    <p className="mt-1 text-[13px] font-medium text-ink-200">{t('Containers shipped FY 2023-24')}</p>
                                </div>
                                <div>
                                    <p className="flex items-center gap-2 text-lg font-bold"><FontAwesomeIcon style={{ fontSize: 18 }} icon={faLocationDot} className="text-brand-300" aria-hidden />{t('2 ports')}</p>
                                    <p className="mt-1 text-[13px] font-medium text-ink-200">{t('Mundra & Kandla, minutes away')}</p>
                                </div>
                            </div>
                            <p className="relative mt-5 border-t border-white/15 pt-4 text-[13px] font-medium leading-relaxed text-ink-200">
                                {t('Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch)')}
                            </p>
                        </div>
                    </div>
                    </div>
                </Container>
            </section>

            {/* Capabilities - dark band with alternating accent tiles so the
                page has real visual rhythm instead of three white card grids. */}
            <section className="relative overflow-hidden bg-ink-950 py-16 text-white sm:py-20">
                <div className="absolute -right-24 -top-24 h-80 w-80 rounded-full border border-white/10" aria-hidden />
                <div className="absolute -bottom-32 -left-16 h-72 w-72 rounded-full border border-white/10" aria-hidden />
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(12,165,235,0.12),transparent_55%)]" aria-hidden />
                <Container className="relative">
                    <div className="mx-auto max-w-3xl text-center">
                        <p className="mb-3 flex items-center justify-center gap-2.5 t-eyebrow text-gold-400">
                            <span className="h-px w-6 bg-gold-400" aria-hidden />{content.capabilities_eyebrow}<span className="h-px w-6 bg-gold-400" aria-hidden />
                        </p>
                        <h2 className="t-h2 text-balance">{content.capabilities_title}</h2>
                        <p className="mt-4 t-lead text-pretty text-ink-200">{content.capabilities_lead}</p>
                    </div>
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {(content.capabilities || []).map((cap, i) => (
                            <Reveal key={cap.title} delay={Math.min(i * 60, 240)} className="h-full">
                                <div className="group h-full rounded-2xl border border-white/10 bg-white/[0.05] p-7 backdrop-blur-sm transition-[transform,border-color,background-color] duration-200 ease-out hover:-translate-y-1 hover:border-brand-400/50 hover:bg-white/[0.08]">
                                    <span className={`inline-flex h-13 w-13 items-center justify-center rounded-2xl text-white shadow-lg sm:h-14 sm:w-14 ${
                                        i % 2 ? 'bg-gradient-to-br from-gold-600 to-gold-500' : 'bg-gradient-to-br from-brand-600 to-brand-400'
                                    }`}>
                                        <Icon name={cap.icon} size={24} />
                                    </span>
                                    <h3 className="mt-5 t-h4 text-white">{cap.title}</h3>
                                    <p className="mt-2 text-[0.9375rem] leading-relaxed text-ink-200">{cap.text}</p>
                                </div>
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Dosage forms - a framed register list, not another card grid */}
            <section className="py-16 sm:py-20">
                <Container>
                    <div className="grid items-start gap-10 lg:grid-cols-[minmax(0,24rem)_1fr]">
                        <div className="lg:sticky lg:top-28">
                            <SectionHeading eyebrow={content.dosage_eyebrow} title={content.dosage_title} align="left" />
                            <div className="mt-8 flex flex-wrap gap-3">
                                <ButtonLink href="/products">{t('Browse the product catalogue')}</ButtonLink>
                                <ButtonLink href="/quality-certifications" variant="outline">{t('Quality & certifications')}</ButtonLink>
                            </div>
                        </div>
                        <div className="overflow-hidden rounded-2xl border border-ink-100 bg-white shadow-card">
                            <ol className="divide-y divide-ink-100">
                                {(content.dosage_forms || []).map((d, i) => (
                                    <li key={d.title} className="card-hover flex gap-5 px-6 py-6 sm:px-8">
                                        <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-brand-100 bg-brand-50 text-brand-700 t-caption font-bold">
                                            {String(i + 1).padStart(2, '0')}
                                        </span>
                                        <div>
                                            <h3 className="text-lg font-semibold text-ink-900">{d.title}</h3>
                                            <p className="mt-1.5 text-[0.9375rem] leading-relaxed text-ink-600">{d.text}</p>
                                        </div>
                                    </li>
                                ))}
                            </ol>
                        </div>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
