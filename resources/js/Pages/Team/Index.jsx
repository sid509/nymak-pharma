import Link from '../../i18n/LocaleLink';
import { ArrowRight } from 'lucide-react';
import { Reveal } from '../../Components/Motion';
import MemberPortrait from '../../Components/MemberPortrait';
import { ButtonLink, Container, PageHero, SectionHeading } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';
import { useT } from '../../i18n/useT';

function MemberCard({ m, i }) {
    const inner = (
        <>
            <div className="aspect-[4/5] overflow-hidden">
                <MemberPortrait member={m} tone={i % 2 ? 'blue' : 'green'} initialClass="text-3xl sm:text-4xl"
                                className="transition-transform duration-500 ease-out group-hover:scale-[1.05]" />
            </div>
            <div className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink-950/90 via-ink-950/45 to-transparent p-3.5 pt-10 sm:p-5 sm:pt-14">
                <h3 className="text-sm font-semibold leading-snug text-white sm:text-base">{m.name}</h3>
                <p className="mt-1 text-xs font-semibold text-brand-300 sm:text-sm">{m.role}</p>
                {m.excerpt && (
                    <p className="mt-0 max-h-0 overflow-hidden text-sm leading-relaxed text-white/70 opacity-0 transition-[max-height,opacity,margin] duration-300 ease-out group-hover:mt-2 group-hover:max-h-24 group-hover:opacity-100">
                        {m.excerpt}
                    </p>
                )}
                {m.has_page && (
                    <span className="mt-2.5 inline-flex items-center gap-1.5 text-xs font-semibold text-white/80">
                        Full profile <ArrowRight size={13} className="btn-arrow" aria-hidden />
                    </span>
                )}
            </div>
        </>
    );

    const cls = 'group relative block h-full overflow-hidden rounded-2xl border border-ink-100 bg-ink-950 shadow-card transition-[transform,box-shadow] duration-300 ease-out hover:-translate-y-1 hover:shadow-card-hover';

    return m.has_page
        ? <Link href={`/team/${m.slug}`} className={cls}>{inner}</Link>
        : <div className={cls}>{inner}</div>;
}

export default function TeamIndex({ seo, leadership, members, content }) {
    const { t } = useT();
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Team']]}
                title={content.hero_title} lead={content.hero_lead} />

            <section className="py-14 sm:py-20">
                <Container>
                    <SectionHeading eyebrow={content.leadership_eyebrow} title={content.leadership_title} />
                    <div className="mt-10 grid gap-5 grid-cols-2 lg:grid-cols-4">
                        {leadership.map((m, i) => (
                            <Reveal key={m.slug || m.name} delay={i * 60}>
                                <MemberCard m={m} i={i} />
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {members.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-14 sm:py-20">
                    <Container>
                        <SectionHeading eyebrow={content.team_eyebrow} title={content.team_title} />
                        <div className="mt-10 grid gap-5 grid-cols-2 lg:grid-cols-4">
                            {members.map((m, i) => (
                                <Reveal key={m.slug || m.name} delay={i * 50}>
                                    <MemberCard m={m} i={i} />
                                </Reveal>
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* Closing CTA — the page shouldn't end on a grid */}
            <section className="py-14 sm:py-16">
                <Container className="text-center">
                    <h2 className="t-h3 text-ink-950">{t('Partnerships start with a conversation')}</h2>
                    <p className="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-ink-600">
                        {t('Distributors, hospitals and health programmes work directly with this team — tell us your market and requirement.')}
                    </p>
                    <div className="mt-6 flex flex-wrap justify-center gap-3">
                        <ButtonLink href="/contact">{t('Contact our team')} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                        <ButtonLink href="/about" variant="outline">{t('About Nymak')}</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
