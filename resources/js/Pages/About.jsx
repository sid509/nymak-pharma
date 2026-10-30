import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowRight, faAward, faBoxesStacked, faCircleCheck, faFlask, faHandHoldingHeart, faShieldHalved } from '@fortawesome/free-solid-svg-icons';
import Link from '../i18n/LocaleLink';

import JourneyTimeline from '../Components/JourneyTimeline';
import MemberPortrait from '../Components/MemberPortrait';
import { Reveal } from '../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';
import { useT } from '../i18n/useT';

const ICONS = { faAward, faCircleCheck, faFlask, faHandHoldingHeart, faBoxesStacked, faShieldHalved };
const Icon = ({ name, size = 22 }) => (
    <FontAwesomeIcon icon={ICONS[name] || faCircleCheck} style={{ fontSize: size }} aria-hidden />
);

const initials = (name) => name.replace('Mr. ', '').replace('Ms. ', '').split(' ').map((w) => w[0]).slice(0, 2).join('');

export default function About({ seo, leadership, team, certifications, content, journey }) {
    const { t } = useT();
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['About Us']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Company overview */}
            <section className="py-16 sm:py-20">
                <Container>
                    <h2 className="mx-auto mb-10 max-w-2xl text-center t-h2 text-balance text-ink-900">{content.overview_title}</h2>
                    <div className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <div className="prose-nymak">
                            <p>{content.overview_p1}</p>
                            <p>{content.overview_p2}</p>
                            <p>{content.overview_p3}</p>
                        </div>
                    </div>
                    <Reveal variant="media" className="rounded-2xl shadow-card">
                        <img src={`/${content.overview_image}`} alt="Nymak Pharma facility, Mundra, among pharmaceutical companies in India since 1998"
                             width="960" height="640" loading="lazy"
                             className="w-full object-cover" />
                    </Reveal>
                    </div>

                    {/* Key strengths - in-house teams that own quality end to end */}
                    <div className="mt-12 grid gap-5 sm:grid-cols-3">
                        {(content.capabilities || []).map((cap, i) => (
                            <Reveal key={cap.title} delay={i * 70} className="h-full">
                                <div className="card-hover group relative h-full overflow-hidden rounded-2xl border border-ink-100 bg-white p-7 shadow-card">
                                    <span className="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-brand-600 to-gold-500 transition-transform duration-300 ease-out group-hover:scale-x-100" aria-hidden />
                                    <span className={`inline-flex h-14 w-14 items-center justify-center rounded-2xl text-white shadow-md ${
                                        i % 2 ? 'bg-gradient-to-br from-gold-600 to-gold-400 shadow-gold-600/20' : 'bg-gradient-to-br from-brand-700 to-brand-500 shadow-brand-700/20'
                                    }`}>
                                        <Icon name={cap.icon} size={26} />
                                    </span>
                                    <h3 className="mt-5 t-h4 text-ink-950">{cap.title}</h3>
                                    <p className="mt-2 text-[0.9375rem] leading-relaxed text-ink-600">{cap.text}</p>
                                </div>
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Founder story */}
            {content.show_story && (
                <section className="border-t border-ink-100 bg-gradient-to-b from-white via-brand-50/40 to-white py-16 sm:py-20">
                    <Container>
                        <div className="grid items-center gap-12 lg:grid-cols-[5fr_6fr]">
                            {/* Archival photo collage */}
                            <Reveal className="order-2 lg:order-1">
                                <div className="relative pb-20 sm:pb-24">
                                    <figure className="relative overflow-hidden rounded-2xl shadow-lg shadow-ink-900/10 ring-1 ring-ink-900/5">
                                        <img src={`/${content.story_image}`} alt={content.story_image_caption}
                                             width="504" height="473" loading="lazy"
                                             className="aspect-[504/473] w-full object-cover" />
                                        <figcaption className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink-950/85 via-ink-950/40 to-transparent px-5 pb-4 pt-10 text-xs font-medium text-white/90">
                                            {content.story_image_caption}
                                        </figcaption>
                                    </figure>
                                    {/* Years badge overlapping top-left */}
                                    <div className="absolute -top-6 left-4 flex h-24 w-24 flex-col items-center justify-center rounded-full bg-brand-600 text-center text-white shadow-lg shadow-brand-900/30 ring-4 ring-white sm:-top-7 sm:-left-7 sm:h-32 sm:w-32">
                                        <span className="text-2xl font-extrabold leading-none sm:text-3xl">{content.story_badge_number}</span>
                                        <span className="mt-1 px-3 text-[10px] font-semibold uppercase leading-tight tracking-[0.06em] text-brand-100 sm:text-[11px]">{content.story_badge_label}</span>
                                    </div>
                                    {/* Archival pair overlapping bottom-right */}
                                    <div className="absolute -bottom-2 right-0 flex items-end gap-3 sm:right-4">
                                        <figure className="w-32 -rotate-2 rounded-xl bg-white p-1.5 shadow-lg shadow-ink-900/15 ring-1 ring-ink-900/5 sm:w-40">
                                            <img src={`/${content.story_archive_1}`} alt={content.story_archive_1_caption}
                                                 width="294" height="208" loading="lazy"
                                                 className="aspect-[294/208] w-full rounded-lg object-cover" />
                                            <figcaption className="px-1 pb-0.5 pt-1.5 text-[10px] font-medium leading-snug text-ink-500">
                                                {content.story_archive_1_caption}
                                            </figcaption>
                                        </figure>
                                        <figure className="w-36 rotate-2 rounded-xl bg-white p-1.5 shadow-lg shadow-ink-900/15 ring-1 ring-ink-900/5 sm:w-44">
                                            <img src={`/${content.story_archive_2}`} alt={content.story_archive_2_caption}
                                                 width="294" height="208" loading="lazy"
                                                 className="aspect-[294/208] w-full rounded-lg object-cover" />
                                            <figcaption className="px-1 pb-0.5 pt-1.5 text-[10px] font-medium leading-snug text-ink-500">
                                                {content.story_archive_2_caption}
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div>
                            </Reveal>
                            {/* Narrative */}
                            <div className="order-1 lg:order-2">
                                <SectionHeading eyebrow={content.story_eyebrow} title={content.story_title} align="left" />
                                <div className="prose-nymak mt-6">
                                    <p>{content.story_p1}</p>
                                    <p>{content.story_p2}</p>
                                    <p>{content.story_p3}</p>
                                </div>
                                <Link href="/team/ranjit-advani" className="card-hover group mt-8 inline-flex items-center gap-4 rounded-2xl border border-ink-100 bg-white py-3 pl-3 pr-6 shadow-card">
                                    <img src="/images/team/ranjit-advani.png" alt={content.story_signature_name}
                                         width="96" height="96" loading="lazy"
                                         className="h-14 w-14 rounded-full object-cover object-top ring-2 ring-brand-100" />
                                    <span>
                                        <span className="block text-base font-bold text-ink-900 group-hover:text-brand-800">{content.story_signature_name}</span>
                                        <span className="block text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{content.story_signature_role}</span>
                                    </span>
                                    <FontAwesomeIcon style={{ fontSize: 16 }} icon={faArrowRight} className="btn-arrow ml-2 text-brand-700" aria-hidden />
                                </Link>
                            </div>
                        </div>
                    </Container>
                </section>
            )}

            {/* Timeline */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.journey_eyebrow} title={content.journey_title} align="center" />
                    <div className="mt-12">
                        <JourneyTimeline items={journey} partners={content.journey_partners || []} />
                    </div>
                </Container>
            </section>

            {/* Values */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.values_eyebrow} title={content.values_title} align="center" />
                    <div className="mt-12 grid gap-5 md:grid-cols-3">
                        {(content.values || []).map((v) => (
                            <div key={v.title} className="card-hover rounded-2xl border border-ink-100 bg-white p-7 text-center shadow-card">
                                <span className="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                    <Icon name={v.icon} />
                                </span>
                                <h3 className="mt-4 t-h4 text-ink-900">{v.title}</h3>
                                <p className="mt-2 text-[0.9375rem] leading-relaxed text-ink-600">{v.text}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Leadership & team */}
            <section className="border-t border-ink-100 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="Leadership" title="The team behind the quality" />
                    <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {leadership.map((m, i) => (
                            <Reveal key={m.name} delay={i * 60} className="h-full">
                                <MemberCard m={m} i={i} />
                            </Reveal>
                        ))}
                    </div>
                    {team?.length > 0 && (
                        <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {team.map((m) => (
                                m.has_page ? (
                                    <Link key={m.name} href={`/team/${m.slug}`}
                                          className="card-hover flex items-center gap-3 rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4 hover:bg-brand-50/60">
                                        {m.photo && <img src={`/${m.photo}`} alt={m.name} width="40" height="40" loading="lazy" className="h-10 w-10 rounded-full object-cover object-top" />}
                                        <div>
                                            <p className="text-[0.9375rem] font-semibold text-ink-900">{m.name}</p>
                                            <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                        </div>
                                    </Link>
                                ) : (
                                    <div key={m.name} className="card-hover flex items-center gap-3 rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4">
                                        {m.photo && <img src={`/${m.photo}`} alt={m.name} width="40" height="40" loading="lazy" className="h-10 w-10 rounded-full object-cover object-top" />}
                                        <div>
                                            <p className="text-[0.9375rem] font-semibold text-ink-900">{m.name}</p>
                                            <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                        </div>
                                    </div>
                                )
                            ))}
                        </div>
                    )}
                </Container>
            </section>

            {/* Certifications - a light credential wall, deliberately distinct
                from the dark footer: framed band, uniform cards, large marks. */}
            <section className="border-t border-ink-100 bg-gradient-to-b from-brand-50/60 via-white to-white py-16 sm:py-24">
                <Container>
                    <SectionHeading eyebrow={content.credentials_eyebrow} title={content.credentials_title} lead={content.credentials_body} />
                    <div className="mt-12 rounded-2xl border border-brand-100 bg-white/80 p-5 shadow-card sm:p-8">
                        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            {certifications.map((c) => (
                                <div key={c.name} className="card-hover flex flex-col items-center rounded-2xl border border-ink-100 bg-white px-8 py-9 text-center shadow-card">
                                    <span className="flex h-24 items-center justify-center">
                                        {c.image ? (
                                            <img src={`/${c.image}`} alt={`${c.name} logo`} width="160" height="160" loading="lazy" className="max-h-24 w-auto object-contain" />
                                        ) : (
                                            <FontAwesomeIcon style={{ fontSize: 48 }} icon={faAward} className="text-brand-600" aria-hidden />
                                        )}
                                    </span>
                                    <p className="mt-5 text-base font-semibold leading-snug text-ink-900">{c.name}</p>
                                    <p className="mt-1 text-[13px] font-medium text-ink-500">{c.issuer}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className="mt-9 text-center">
                        <ButtonLink href="/quality-certifications">{t('Quality & certifications')}</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}

/** Leadership card - portrait band on top, identity below; links to the
    member's profile page when one exists. */
function MemberCard({ m, i }) {
    const member = { ...m, initials: m.initials || initials(m.name) };
    const body = (
        <>
            <div className="aspect-[4/3]">
                <MemberPortrait member={member} tone={i % 2 ? 'blue' : 'green'}
                                photoClass="h-32 w-32 sm:h-36 sm:w-36" initialClass="text-4xl" />
            </div>
            <div className="p-5">
                <h3 className="t-h4 leading-snug text-ink-900">{m.name}</h3>
                <p className="mt-1 text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{m.role}</p>
                {m.has_page && (
                    <span className="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                        Full profile <FontAwesomeIcon style={{ fontSize: 14 }} icon={faArrowRight} className="btn-arrow" aria-hidden />
                    </span>
                )}
            </div>
        </>
    );
    const cls = 'card-hover block h-full overflow-hidden rounded-2xl border border-ink-100 bg-white shadow-card';
    return m.has_page
        ? <Link href={`/team/${m.slug}`} className={cls}>{body}</Link>
        : <div className={cls}>{body}</div>;
}
