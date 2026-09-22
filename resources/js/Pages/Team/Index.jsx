import { Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import { Reveal } from '../../Components/Motion';
import { Container, Eyebrow, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

function MemberCard({ m, large = false }) {
    const inner = (
        <>
            {m.photo ? (
                <img src={`/${m.photo}`} alt={m.name} loading="lazy"
                     className={`${large ? 'h-56' : 'h-44'} w-full object-cover object-top`} />
            ) : (
                <div className={`${large ? 'h-56' : 'h-44'} grid w-full place-items-center bg-gradient-to-br from-brand-50 to-brand-100`}>
                    <span className="flex h-16 w-16 items-center justify-center rounded-full bg-brand-700 text-xl font-extrabold text-white">
                        {m.initials}
                    </span>
                </div>
            )}
            <div className="p-5">
                <h3 className="font-extrabold text-ink-900">{m.name}</h3>
                <p className="mt-0.5 text-sm font-semibold text-brand-700">{m.role}</p>
                {m.excerpt && <p className="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-500">{m.excerpt}</p>}
                {m.has_page && (
                    <span className="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-700">
                        Full profile <ArrowRight size={13} className="btn-arrow" aria-hidden />
                    </span>
                )}
            </div>
        </>
    );

    const cls = `group block h-full overflow-hidden rounded-2xl border border-ink-100 bg-white transition-shadow hover:shadow-lg hover:shadow-ink-900/5`;

    return m.has_page
        ? <Link href={`/team/${m.slug}`} className={cls}>{inner}</Link>
        : <div className={cls}>{inner}</div>;
}

export default function TeamIndex({ seo, leadership, members, content }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Team']]}
                title={content.hero_title} lead={content.hero_lead} />

            <section className="py-14 sm:py-20">
                <Container>
                    <Eyebrow>{content.leadership_eyebrow}</Eyebrow>
                    <h2 className="mt-2 text-3xl font-extrabold tracking-tight text-ink-950">{content.leadership_title}</h2>
                    <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {leadership.map((m, i) => (
                            <Reveal key={m.slug || m.name} delay={i * 60}>
                                <MemberCard m={m} large />
                            </Reveal>
                        ))}
                    </div>
                </Container>
            </section>

            {members.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-14 sm:py-20">
                    <Container>
                        <Eyebrow>{content.team_eyebrow}</Eyebrow>
                        <h2 className="mt-2 text-3xl font-extrabold tracking-tight text-ink-950">{content.team_title}</h2>
                        <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            {members.map((m, i) => (
                                <Reveal key={m.slug || m.name} delay={i * 50}>
                                    <MemberCard m={m} />
                                </Reveal>
                            ))}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
