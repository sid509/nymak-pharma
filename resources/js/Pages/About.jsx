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
                <Container className="grid items-start gap-10 lg:grid-cols-2">
                    <div className="prose-nymak">
                        <h2>{content.overview_title}</h2>
                        <p>{content.overview_p1}</p>
                        <p>{content.overview_p2}</p>
                        <p>{content.overview_p3}</p>
                    </div>
                    <div>
                        <img src={`/${content.overview_image}`} alt="Nymak Pharma facility aerial view, Mundra, Gujarat"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="mt-6 grid grid-cols-3 gap-3">
                            {(content.capabilities || []).map((c) => (
                                <div key={c.title} className="rounded-2xl border border-ink-100 bg-ink-50/50 p-4">
                                    <Icon name={c.icon} />
                                    <p className="mt-2 text-sm font-bold text-ink-900">{c.title}</p>
                                    <p className="mt-1 text-xs leading-relaxed text-ink-500">{c.text}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </Container>
            </section>

            {/* Timeline */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.journey_eyebrow} title={content.journey_title} />
                    <ol className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {(content.timeline || []).map((t) => (
                            <li key={t.year + t.title} className="relative rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <p className="text-3xl font-extrabold tracking-tight text-brand-700">{t.year}</p>
                                <h3 className="mt-2 text-base font-bold text-ink-900">{t.title}</h3>
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
                                <h3 className="mt-4 text-lg font-bold text-ink-900">{v.title}</h3>
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
                                            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-brand-700 text-base font-extrabold text-white">
                                                {initials(m.name)}
                                            </span>
                                        )}
                                        <h3 className="mt-4 text-base font-bold text-ink-900 group-hover:text-brand-800">{m.name}</h3>
                                        <p className="mt-0.5 text-xs font-semibold uppercase tracking-wider text-brand-700">{m.role}</p>
                                        <span className="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-700">
                                            Profile <ArrowRight size={12} className="btn-arrow" aria-hidden />
                                        </span>
                                    </Link>
                                ) : (
                                    <div className="h-full rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                        {m.photo ? (
                                            <img src={`/${m.photo}`} alt={m.name} width="96" height="96" loading="lazy"
                                                 className="h-12 w-12 rounded-full object-cover object-top" />
                                        ) : (
                                            <span className="flex h-12 w-12 items-center justify-center rounded-full bg-brand-700 text-base font-extrabold text-white">
                                                {initials(m.name)}
                                            </span>
                                        )}
                                        <h3 className="mt-4 text-base font-bold text-ink-900">{m.name}</h3>
                                        <p className="mt-0.5 text-xs font-semibold uppercase tracking-wider text-brand-700">{m.role}</p>
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
                                            <p className="text-sm font-bold text-ink-900">{m.name}</p>
                                            <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                        </div>
                                    </Link>
                                ) : (
                                    <div key={m.name} className="flex items-center gap-3 rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4">
                                        {m.photo && <img src={`/${m.photo}`} alt={m.name} width="40" height="40" loading="lazy" className="h-9 w-9 rounded-full object-cover object-top" />}
                                        <div>
                                            <p className="text-sm font-bold text-ink-900">{m.name}</p>
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
                <Container className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">{content.credentials_eyebrow}</p>
                        <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">{content.credentials_title}</h2>
                        <p className="mt-4 leading-relaxed text-ink-200">
                            {content.credentials_body}
                        </p>
                        <ButtonLink href="/quality-certifications" className="mt-6">Quality & certifications</ButtonLink>
                    </div>
                    <div className="grid grid-cols-2 gap-4">
                        {certifications.slice(0, 4).map((c) => (
                            <div key={c.name} className="rounded-xl border border-ink-700 bg-ink-900 p-4 text-center">
                                {c.image && <img src={`/${c.image}`} alt={`${c.name} logo`} width="120" height="120" loading="lazy" className="mx-auto h-14 w-auto object-contain" />}
                                <p className="mt-3 text-xs font-bold">{c.name}</p>
                                <p className="text-[11px] text-ink-400">{c.issuer}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
