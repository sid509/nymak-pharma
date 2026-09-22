import { Link, usePage } from '@inertiajs/react';
import { ArrowRight, Award, BadgeCheck, Download, Globe2, MapPin, Quote } from 'lucide-react';
import Accordion from '../Components/Accordion';
import { CategoryCard, PostCard, ProductCard } from '../Components/Cards';
import { ButtonLink, Container, Eyebrow, SectionHeading, Stat } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Home({ seo, categories, featuredProducts, testimonials, certifications, posts, faqs, stats }) {
    const { site } = usePage().props;

    return (
        <SiteLayout>
            {/* Hero — facility aerial photograph, real company imagery */}
            <section className="relative isolate overflow-hidden bg-ink-950">
                <img src="/images/hero/facility-aerial.webp" alt="Aerial view of the Nymak Pharma facility in Mundra, Gujarat"
                     width="1920" height="1280" fetchpriority="high"
                     className="absolute inset-0 -z-10 h-full w-full object-cover opacity-40" />
                <div className="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/95 via-ink-950/75 to-ink-950/30" />
                <Container className="py-20 sm:py-28 lg:py-32">
                    <div className="max-w-2xl">
                        <p className="inline-flex items-center gap-2 rounded-full border border-brand-400/40 bg-brand-900/40 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-brand-200">
                            <BadgeCheck size={14} aria-hidden /> WHO-GMP Certified · Star Export House
                        </p>
                        <h1 className="mt-6 text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Efficacy-Driven Lifecare, Exported Worldwide
                        </h1>
                        <p className="mt-6 max-w-xl text-lg leading-relaxed text-ink-100">
                            Nymak Pharma is a pharmaceutical manufacturer and exporter in India supplying
                            IV fluids, finished formulations, medical devices, rapid diagnostic kits and
                            vaccines to partners in more than 24 countries.
                        </p>
                        <div className="mt-8 flex flex-wrap gap-3">
                            <ButtonLink href="/products">Explore Our Products <ArrowRight size={16} aria-hidden /></ButtonLink>
                            <ButtonLink href="/contact" variant="light">Partner With Us</ButtonLink>
                            <a href="/nymak-pharma-brochure.pdf" target="_blank" rel="noopener noreferrer"
                               onClick={() => window.nymakTrack && window.nymakTrack('brochure_download')}
                               className="inline-flex items-center gap-1.5 self-center text-sm font-bold text-brand-200 underline-offset-4 hover:text-white hover:underline">
                                <Download size={15} aria-hidden /> Download Brochure
                            </a>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Stats */}
            <section className="bg-brand-800">
                <Container className="grid grid-cols-2 gap-8 py-12 sm:py-14 lg:grid-cols-4">
                    <Stat value={stats.years} label="Years of Lifecare" />
                    <Stat value={stats.countries} label="Export Countries" />
                    <Stat value={stats.containers_fy} label="Containers in FY 23–24" />
                    <Stat value={stats.products} label="Products in Portfolio" />
                </Container>
            </section>

            {/* About preview */}
            <section className="py-16 sm:py-24">
                <Container className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <Eyebrow>About Nymak Pharma</Eyebrow>
                        <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                            A pharmaceutical manufacturer India has exported through since 1998
                        </h2>
                        <div className="prose-nymak mt-5">
                            <p>
                                Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began
                                with Sterilized Water for Injections BP in plastic ampoules, serving the South
                                Pacific. From those beginnings we grew into Honduras, then Nigeria in 2000 —
                                a milestone that lifted exports by 25% and opened our expansion across Africa.
                            </p>
                            <p>
                                Today we operate from a WHO-GMP certified facility in Mundra, Gujarat, supported
                                by in-house regulatory, laboratory, QC/QA and design teams — and recognised as a
                                Government of India certified Star Export House.
                            </p>
                        </div>
                        <div className="mt-6 flex flex-wrap gap-3">
                            <ButtonLink href="/about" variant="outline">Our Story <ArrowRight size={15} aria-hidden /></ButtonLink>
                            <ButtonLink href="/manufacturing" variant="ghost">See our facility</ButtonLink>
                        </div>
                    </div>
                    <div className="relative">
                        <img src="/images/hero/facility-aerial.webp" alt="Nymak Pharma manufacturing plant, Mundra"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="absolute -bottom-5 -left-4 rounded-2xl bg-brand-700 px-5 py-4 text-white shadow-card sm:-left-6">
                            <p className="text-2xl font-extrabold">Since 1998</p>
                            <p className="text-xs font-semibold uppercase tracking-wider text-brand-200">Mundra, Gujarat, India</p>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Product categories */}
            <section className="bg-ink-50 py-16 sm:py-24">
                <Container>
                    <SectionHeading eyebrow="Our Portfolio" align="center"
                        title="Five product segments, one quality standard"
                        lead="A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes." />
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                        {categories.map((c) => <CategoryCard key={c.id} category={c} href={`/products/${c.slug}`} />)}
                    </div>
                </Container>
            </section>

            {/* Branded products */}
            {featuredProducts?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <div className="flex flex-wrap items-end justify-between gap-4">
                            <SectionHeading eyebrow="Marketed Brands"
                                title="The Nymak branded range"
                                lead="Registered brands supplied across West African markets — each manufactured under WHO-GMP conditions." />
                            <ButtonLink href="/products" variant="outline">Full catalogue <ArrowRight size={15} aria-hidden /></ButtonLink>
                        </div>
                        <div className="mt-10 grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                            {featuredProducts.map((p) => (
                                <ProductCard key={p.id} product={p}
                                    url={`/products/${p.category.slug}/${p.slug}`} />
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* Quality & certifications strip */}
            <section className="border-y border-ink-100 bg-white py-16 sm:py-20">
                <Container className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <Eyebrow>Quality & Compliance</Eyebrow>
                        <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                            Certified for the markets that demand proof
                        </h2>
                        <p className="mt-4 text-lg leading-relaxed text-ink-600">
                            Every batch is analysed by our in-house QC laboratory and released through QA review.
                            Our regulatory team supports dossiers and registrations in destination markets.
                        </p>
                        <ButtonLink href="/quality-certifications" variant="outline" className="mt-6">
                            All certifications <ArrowRight size={15} aria-hidden />
                        </ButtonLink>
                    </div>
                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        {certifications.slice(0, 4).map((c) => (
                            <div key={c.name} className="flex flex-col items-center rounded-2xl border border-ink-100 bg-ink-50/50 p-4 text-center">
                                {c.image ? (
                                    <img src={`/${c.image}`} alt={`${c.name} certification logo`} width="120" height="120" loading="lazy"
                                         className="h-16 w-auto object-contain" />
                                ) : (
                                    <Award size={40} className="text-brand-600" aria-hidden />
                                )}
                                <p className="mt-3 text-xs font-bold leading-tight text-ink-800">{c.name}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Global presence */}
            <section className="bg-ink-950 py-16 text-white sm:py-24">
                <Container className="grid items-center gap-10 lg:grid-cols-2">
                    <div>
                        <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">Global Presence</p>
                        <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">
                            From Mundra to 24+ country markets
                        </h2>
                        <p className="mt-4 text-lg leading-relaxed text-ink-200">
                            Operating across West, Central and East Africa, Central America and the South
                            Pacific — with offices in the UK, Sierra Leone and Liberia, and products like
                            Alumak, Cefmak and Cipromak registered under local partnerships.
                        </p>
                        <ButtonLink href="/global-presence" variant="primary" className="mt-6">
                            Explore our markets <Globe2 size={16} aria-hidden />
                        </ButtonLink>
                    </div>
                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        {['Nigeria', 'Sierra Leone', 'Liberia', 'Somalia', 'Kenya', 'DR Congo', 'Cameroon', 'Mauritania', 'Honduras'].map((m) => (
                            <div key={m} className="flex items-center gap-2 rounded-xl border border-ink-700 bg-ink-900 px-4 py-3 text-sm font-semibold">
                                <MapPin size={14} className="shrink-0 text-brand-400" aria-hidden /> {m}
                            </div>
                        ))}
                        <div className="flex items-center gap-2 rounded-xl border border-brand-500/40 bg-brand-900/50 px-4 py-3 text-sm font-bold text-brand-200">
                            + more markets
                        </div>
                    </div>
                </Container>
            </section>

            {/* Testimonials */}
            {testimonials?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow="Partner Feedback" align="center" title="What our clients say" />
                        <div className="mt-12 grid gap-5 md:grid-cols-3">
                            {testimonials.map((t) => (
                                <figure key={t.name} className="flex flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                    <Quote size={24} className="text-brand-500" aria-hidden />
                                    <blockquote className="mt-4 flex-1 text-sm leading-relaxed text-ink-700">{t.quote}</blockquote>
                                    <figcaption className="mt-5 border-t border-ink-100 pt-4">
                                        <p className="text-sm font-bold text-ink-900">{t.name}</p>
                                        <p className="text-xs font-semibold text-ink-500">{t.country}</p>
                                    </figcaption>
                                </figure>
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* Client logos */}
            <section className="border-t border-ink-100 bg-ink-50/60 py-14">
                <Container>
                    <p className="text-center text-xs font-bold uppercase tracking-[0.2em] text-ink-500">
                        Trusted by pharmaceutical partners across markets
                    </p>
                    <div className="mt-8 grid grid-cols-3 items-center gap-6 sm:grid-cols-4 lg:grid-cols-7">
                        {['davimed', 'prince-pharma', 'sam-pharma', 'satguru-group-logo', 'syner-med-logo', 'trucare', 'unique-pharma-logo', 'westgate-pharmaceuticals', 'xanaano-pharma-logo', 'zawadi-logo', 'zee-pharma', 'core-africa-liberia-inc'].map((logo) => (
                            <img key={logo} src={`/images/clients/${logo}.webp`} alt={`${logo.replace(/-/g, ' ')} — Nymak Pharma client`}
                                 width="200" height="120" loading="lazy"
                                 className="mx-auto h-12 w-auto object-contain opacity-80 transition-opacity hover:opacity-100" />
                        ))}
                    </div>
                </Container>
            </section>

            {/* FAQs */}
            {faqs?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container className="grid gap-10 lg:grid-cols-[1fr_1.4fr]">
                        <div>
                            <Eyebrow>FAQs</Eyebrow>
                            <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                                Questions partners ask us
                            </h2>
                            <p className="mt-4 text-ink-600">
                                Straight answers about who we are, what we make, and how we export.
                            </p>
                            <ButtonLink href="/faqs" variant="outline" className="mt-6">All FAQs <ArrowRight size={15} aria-hidden /></ButtonLink>
                        </div>
                        <Accordion items={faqs} />
                    </Container>
                </section>
            )}

            {/* Latest posts */}
            {posts?.length > 0 && (
                <section className="bg-ink-50 py-16 sm:py-24">
                    <Container>
                        <div className="flex flex-wrap items-end justify-between gap-4">
                            <SectionHeading eyebrow="Insights" title="From the Nymak journal" />
                            <ButtonLink href="/blog" variant="outline">All articles <ArrowRight size={15} aria-hidden /></ButtonLink>
                        </div>
                        <div className="mt-10 grid gap-5 md:grid-cols-3">
                            {posts.map((p) => <PostCard key={p.slug} post={p} />)}
                        </div>
                    </Container>
                </section>
            )}

            {/* CTA */}
            <section className="bg-brand-700">
                <Container className="flex flex-col items-start justify-between gap-6 py-14 sm:flex-row sm:items-center">
                    <div>
                        <h2 className="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                            Have a requirement? Let's talk.
                        </h2>
                        <p className="mt-2 max-w-xl text-brand-100">
                            Product enquiries, distribution partnerships, tenders and registration support —
                            our exports team responds to every enquiry.
                        </p>
                    </div>
                    <div className="flex flex-wrap gap-3">
                        <ButtonLink href="/contact" variant="light">Send an enquiry <ArrowRight size={15} aria-hidden /></ButtonLink>
                        <ButtonLink href={`https://wa.me/${site.whatsapp}`} external variant="outline" className="border-white/40 text-white hover:border-white hover:text-white">
                            WhatsApp us
                        </ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
