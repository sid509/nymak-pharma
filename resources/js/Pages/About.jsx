import { Award, BadgeCheck, FlaskConical, HeartHandshake, PackageCheck, ShieldCheck } from 'lucide-react';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const timeline = [
    { year: '1998', title: 'Founded in Gujarat', text: 'Mr. Ranjit Advani establishes Nymak Pharma, beginning with Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules for South Pacific markets.' },
    { year: '2000', title: 'The Nigeria milestone', text: 'Entry into the Nigerian market lifts export sales by 25% and opens wider expansion across the African continent.' },
    { year: '2000s', title: 'Portfolio diversification', text: 'From water for injections, the range grows into pharmaceuticals, IV fluids, medical devices and disposables for export markets.' },
    { year: 'Today', title: '24+ countries, 200+ containers', text: 'A Government of India certified Star Export House operating from a WHO-GMP facility in Mundra, with offices in the UK, Sierra Leone and Liberia.' },
];

const values = [
    { icon: ShieldCheck, title: 'Efficacy', text: 'Every product must work as promised. Efficacy is the standard by which we formulate, manufacture and release.' },
    { icon: HeartHandshake, title: 'Customer-first', text: 'Behind every product is a person in need. We build for the patient at the end of the supply chain and the partner who places the order.' },
    { icon: BadgeCheck, title: 'Sincerity', text: 'Transparent dealings, honest documentation, certifications that can be verified. Trust is the real export.' },
];

const capabilities = [
    { icon: FlaskConical, title: 'In-house QC laboratory', text: 'Batch lots are analysed by quality control before release.' },
    { icon: PackageCheck, title: 'QA oversight', text: 'A dedicated quality assurance function reviews and approves every release.' },
    { icon: Award, title: 'Regulatory team', text: 'Dossier preparation and product registration support for destination markets.' },
];

export default function About({ seo, leadership, team, certifications }) {
    return (
        <SiteLayout>
            <PageHero eyebrow="About Us" breadcrumbs={[['Home', '/'], ['About Us']]}
                title="25+ years of efficacy-driven lifecare"
                lead="From a single injectable for the South Pacific to a Star Export House supplying 24+ countries — the story of Nymak Pharma is a story of quality compounding." />

            {/* Company overview */}
            <section className="py-16 sm:py-20">
                <Container className="grid items-start gap-10 lg:grid-cols-2">
                    <div className="prose-nymak">
                        <h2>Company overview</h2>
                        <p>
                            Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, Nymak Pharma
                            embarked on its journey producing Sterilized Water for Injections BP in 5 ml and
                            10 ml plastic ampoules. Our beginnings were humble — our first clients were in the
                            South Pacific, where we established our dedication to quality, service and efficacy,
                            always remembering that behind every product is a person in need.
                        </p>
                        <p>
                            As our expertise flourished, so did our reach — several island markets across the
                            South Pacific, then Honduras in Central America. Anticipating evolving needs, we
                            diversified into a wide array of pharmaceuticals and medical devices built for the
                            healthcare challenges faced by the communities we serve.
                        </p>
                        <p>
                            Today, with over 25 years of lifecare excellence, Nymak Pharma maintains a presence
                            in more than 24 countries and exported over 200 containers in FY 2023–24. As a
                            Government of India certified Star Export House, our infrastructure includes an
                            in-house regulatory team, a quality control laboratory, a committed warehouse and
                            passionate QC/QA and design teams — all devoted to the highest standards of care
                            and excellence.
                        </p>
                    </div>
                    <div>
                        <img src="/images/hero/facility-aerial.webp" alt="Nymak Pharma facility aerial view, Mundra, Gujarat"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="mt-6 grid grid-cols-3 gap-3">
                            {capabilities.map((c) => (
                                <div key={c.title} className="rounded-2xl border border-ink-100 bg-ink-50/50 p-4">
                                    <c.icon size={22} className="text-brand-700" aria-hidden />
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
                    <SectionHeading eyebrow="Our Journey" title="Milestones that shaped Nymak" />
                    <ol className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {timeline.map((t) => (
                            <li key={t.year} className="relative rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
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
                    <SectionHeading eyebrow="What guides us" title="Values behind the products" align="center" />
                    <div className="mt-12 grid gap-5 md:grid-cols-3">
                        {values.map((v) => (
                            <div key={v.title} className="rounded-2xl border border-ink-100 bg-white p-7 text-center shadow-card">
                                <span className="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                    <v.icon size={22} aria-hidden />
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
                            <div key={m.name} className="rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <span className="flex h-12 w-12 items-center justify-center rounded-full bg-brand-700 text-base font-extrabold text-white">
                                    {m.name.replace('Mr. ', '').replace('Ms. ', '').split(' ').map((w) => w[0]).slice(0, 2).join('')}
                                </span>
                                <h3 className="mt-4 text-base font-bold text-ink-900">{m.name}</h3>
                                <p className="mt-0.5 text-xs font-semibold uppercase tracking-wider text-brand-700">{m.role}</p>
                            </div>
                        ))}
                    </div>
                    {team?.length > 0 && (
                        <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {team.map((m) => (
                                <div key={m.name} className="rounded-xl border border-ink-100 bg-ink-50/50 px-5 py-4">
                                    <p className="text-sm font-bold text-ink-900">{m.name}</p>
                                    <p className="text-xs font-medium text-ink-500">{m.role}</p>
                                </div>
                            ))}
                        </div>
                    )}
                </Container>
            </section>

            {/* Certifications */}
            <section className="bg-ink-950 py-16 text-white sm:py-20">
                <Container className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">Credentials</p>
                        <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">Verified, not just claimed</h2>
                        <p className="mt-4 leading-relaxed text-ink-200">
                            WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House
                            recognition and Pharmexcil membership — credentials that regulators and partners can verify.
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
