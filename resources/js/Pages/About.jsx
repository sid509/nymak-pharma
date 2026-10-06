import { Link } from '@inertiajs/react';
import { ArrowRight, Award, BadgeCheck, FlaskConical, HeartHandshake, PackageCheck, ShieldCheck } from 'lucide-react';
import { Reveal } from '../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const ICONS = { Award, BadgeCheck, FlaskConical, HeartHandshake, PackageCheck, ShieldCheck };
const Icon = ({ name, size = 22 }) => {
    const C = ICONS[name] || BadgeCheck;
    return <C size={size} aria-hidden />;
};

const initials = (name) => name.replace('Mr. ', '').replace('Ms. ', '').split(' ').map((w) => w[0]).slice(0, 2).join('');

export default function About({ seo, leadership, team, certifications, content }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['About Us']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            {/* Company overview */}
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
                    <div>
                        <img src={`/${content.overview_image}`} alt="Nymak Pharma facility aerial view, Mundra, Gujarat"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="mt-6 grid grid-cols-3 gap-3">
                            {(content.capabilities || []).map((c) => (
                                <div key={c.title} className="rounded-2xl border border-ink-100 bg-ink-50/50 p-4">
                                    <Icon name={c.icon} />
                                    <p className="mt-2 text-sm font-semibold text-ink-900">{c.title}</p>
                                    <p className="mt-1 text-xs leading-relaxed text-ink-500">{c.text}</p>
                                </div>
                            ))}
                        </div>
                    </div>
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
                                    <figure className="relative overflow-hidden rounded-3xl shadow-lg shadow-ink-900/10 ring-1 ring-ink-900/5">
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
                                <Link href="/team/ranjit-advani" className="group mt-8 inline-flex items-center gap-4 rounded-2xl border border-ink-100 bg-white py-3 pl-3 pr-6 shadow-card transition-shadow hover:shadow-lg hover:shadow-ink-900/5">
                                    <img src="/images/team/ranjit-advani.png" alt={content.story_signature_name}
                                         width="96" height="96" loading="lazy"
                                         className="h-14 w-14 rounded-full object-cover object-top ring-2 ring-brand-100" />
                                    <span>
                                        <span className="block text-base font-bold text-ink-900 group-hover:text-brand-800">{content.story_signature_name}</span>
                                        <span className="block text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{content.story_signature_role}</span>
                                    </span>
                                    <ArrowRight size={16} className="btn-arrow ml-2 text-brand-700" aria-hidden />
                                </Link>
                            </div>
                        </div>
                    </Container>
                </section>
            )}

            {/* Timeline */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.journey_eyebrow} title={content.journey_title} />
                    <ol className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {(content.timeline || []).map((t) => (
                            <li key={t.year + t.title} className="relative rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <p className="text-3xl font-bold tracking-tight text-brand-700">{t.year}</p>
                                <h3 className="mt-2 t-h4 text-ink-900">{t.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-ink-600">{t.text}</p>
                            </li>
                        ))}
                    </ol>
                </Container>
            </section>

            {/* Values */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.values_eyebrow} title={content.values_title} align="center" />
                    <div className="mt-12 grid gap-5 md:grid-cols-3">
                        {(content.values || []).map((v) => (
                            <div key={v.title} className="rounded-2xl border border-ink-100 bg-white p-7 text-center shadow-card">
                                <span className="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                    <Icon name={v.icon} />
                                </span>
                                <h3 className="mt-4 t-h4 text-ink-900">{v.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-ink-600">{v.text}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Leadership & team */}
            <section className="border-t border-ink-100 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="Leadership" title="The team behind the quality" />
                    <div className="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        {leadership.map((m) => (
                            <Reveal key={m.name}>
                                {m.has_page ? (
                                    <Link href={`/team/${m.slug}`}
                                          className="group block h-full rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-shadow hover:shadow-lg hover:shadow-ink-900/5">
                                        {m.photo ? (
                                            <img src={`/${m.photo}`} alt={m.name} width="96" height="96" loading="lazy"
                                                 className="h-12 w-12 rounded-full object-cover object-top" />
                                        ) : (
                                            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-brand-700 t-h4 text-white">
                                                {initials(m.name)}
                                            </span>
                                        )}
                                        <h3 className="mt-4 t-h4 text-ink-900 group-hover:text-brand-800">{m.name}</h3>
                                        <p className="mt-0.5 text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{m.role}</p>
                                        <span className="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-brand-700">
                                            Profile <ArrowRight size={12} className="btn-arrow" aria-hidden />
                                        </span>
                                    </Link>
                                ) : (
                                    <div className="h-full rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                        {m.photo ? (
                                            <img src={`/${m.photo}`} alt={m.name} width="96" height="96" loading="lazy"
                                                 className="h-12 w-12 rounded-full object-cover object-top" />
                                        ) : (
                                            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-brand-700 t-h4 text-white">
                                                {initials(m.name)}
                                            </span>
                                        )}
                                        <h3 className="mt-4 t-h4 text-ink-900">{m.name}</h3>
                                        <p className="mt-0.5 text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{m.role}</p>
                                    </div>
                                )}
                            </Reveal>
                        ))}
                    </div>
                    {team?.length > 0 && (
                        <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {team.map((m) => (
                                m.has_page ? (
                                    <Link key={m.name} href={`/team/${m.slug}`}
                                          className="flex items-center gap-3 rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4 transition-colors hover:border-brand-200 hover:bg-brand-50/60">
                                        {m.photo && <img src={`/${m.photo}`} alt={m.name} width="40" height="40" loading="lazy" className="h-9 w-9 rounded-full object-cover object-top" />}
                                        <div>
                                            <p className="text-sm font-semibold text-ink-900">{m.name}</p>
                                            <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                        </div>
                                    </Link>
                                ) : (
                                    <div key={m.name} className="flex items-center gap-3 rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4">
                                        {m.photo && <img src={`/${m.photo}`} alt={m.name} width="40" height="40" loading="lazy" className="h-9 w-9 rounded-full object-cover object-top" />}
                                        <div>
                                            <p className="text-sm font-semibold text-ink-900">{m.name}</p>
                                            <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                        </div>
                                    </div>
                                )
                            ))}
                        </div>
                    )}
                </Container>
            </section>

            {/* Certifications */}
            <section className="bg-ink-950 py-16 text-white sm:py-20">
                <Container>
                    <div className="mx-auto max-w-2xl text-center">
                        <p className="mb-3 flex items-center justify-center gap-2.5 text-xs font-semibold uppercase tracking-[0.04em] text-brand-300">
                            <span className="h-px w-6 bg-brand-400" aria-hidden />{content.credentials_eyebrow}<span className="h-px w-6 bg-brand-400" aria-hidden />
                        </p>
                        <h2 className="t-h2">{content.credentials_title}</h2>
                        <p className="mt-4 leading-relaxed text-ink-200">
                            {content.credentials_body}
                        </p>
                    </div>
                    <div className="mx-auto mt-10 grid max-w-4xl grid-cols-2 gap-4 sm:grid-cols-4">
                        {certifications.slice(0, 4).map((c) => (
                            <div key={c.name} className="rounded-xl border border-ink-700 bg-ink-900 p-4 text-center">
                                {c.image && <img src={`/${c.image}`} alt={`${c.name} logo`} width="120" height="120" loading="lazy" className="mx-auto h-14 w-auto object-contain" />}
                                <p className="mt-3 text-xs font-semibold">{c.name}</p>
                                <p className="text-xs text-ink-400">{c.issuer}</p>
                            </div>
                        ))}
                    </div>
                    <div className="mt-9 text-center">
                        <ButtonLink href="/quality-certifications">Quality & certifications</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
