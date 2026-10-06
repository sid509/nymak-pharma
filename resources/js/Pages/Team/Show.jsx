import Link from '../../i18n/LocaleLink';
import { ArrowLeft, ArrowRight } from 'lucide-react';
import { Reveal } from '../../Components/Motion';
import MemberPortrait, { portraitTone } from '../../Components/MemberPortrait';
import { ButtonLink, Container, Eyebrow } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';
import { useT } from '../../i18n/useT';

export default function TeamShow({ seo, member, others }) {
    const { t } = useT();
    return (
        <SiteLayout>
            <section className="border-b border-ink-100 bg-gradient-to-b from-brand-50/60 to-white py-14 sm:py-20">
                <Container>
                    <Link href="/team" className="inline-flex items-center gap-1.5 text-sm font-semibold text-ink-500 hover:text-brand-700">
                        <ArrowLeft size={15} aria-hidden /> All team
                    </Link>
                    <div className="mt-8 grid items-start gap-10 lg:grid-cols-[minmax(0,20rem)_1fr]">
                        <Reveal>
                            <div className="aspect-[4/5] w-full overflow-hidden rounded-2xl shadow-xl shadow-brand-900/10">
                                <MemberPortrait member={member} initialClass="text-7xl" photoClass="h-48 w-48 sm:h-60 sm:w-60" />
                            </div>
                        </Reveal>
                        <Reveal delay={80}>
                            <Eyebrow>{member.role}</Eyebrow>
                            <h1 className="mt-3 t-page text-ink-950">{member.name}</h1>
                            <div className="prose-nymak mt-6 max-w-2xl">
                                {member.bio.split(/\n{2,}/).map((p, i) => <p key={i}>{p}</p>)}
                            </div>
                            <div className="mt-8 flex flex-wrap gap-3">
                                <ButtonLink href="/contact">{t('Work with us')} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                <ButtonLink href="/about" variant="outline">{t('About the company')}</ButtonLink>
                            </div>
                        </Reveal>
                    </div>
                </Container>
            </section>

            {others.length > 0 && (
                <section className="py-14 sm:py-16">
                    <Container>
                        <h2 className="t-h3 text-ink-900">{t('More of the team')}</h2>
                        <div className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {others.map((m, i) => (
                                <Reveal key={m.slug} delay={i * 50}>
                                    <Link href={`/team/${m.slug}`}
                                          className="group flex items-center gap-3 rounded-xl border border-ink-100 bg-white p-4 transition-shadow hover:shadow-md">
                                        {m.photo ? (
                                            <img src={`/${m.photo}`} alt="" loading="lazy"
                                                 className="h-12 w-12 shrink-0 rounded-full object-cover object-top" />
                                        ) : (
                                            <span className={`flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-sm font-semibold text-white ${portraitTone(m) === 'blue' ? 'from-gold-700 to-gold-500' : 'from-brand-700 to-brand-500'}`}>
                                                {m.initials}
                                            </span>
                                        )}
                                        <span>
                                            <span className="block text-sm font-semibold text-ink-900 group-hover:text-brand-800">{m.name}</span>
                                            <span className="block text-xs text-ink-500">{m.role}</span>
                                        </span>
                                    </Link>
                                </Reveal>
                            ))}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
