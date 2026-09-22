import { Link, usePage } from '@inertiajs/react';
import { ArrowRight, Award, BadgeCheck, Download, Globe2, MapPin, Quote } from 'lucide-react';
import Accordion from '../Components/Accordion';
import { CategoryCard, PostCard, ProductCard } from '../Components/Cards';
import { ButtonLink, Container, Eyebrow, SectionHeading, Stat } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Home({ seo, categories, featuredProducts, testimonials, certifications, posts, faqs, stats, clients = [], markets = [], content }) {
    const { site } = usePage().props;

    return (
        <SiteLayout>
            {/* Hero — facility aerial photograph, real company imagery */}
            <section className="relative isolate overflow-hidden bg-ink-950">
                <img src={`/${content.hero_image}`} alt="Nymak Pharma facility, Mundra, Gujarat"
                     width="1920" height="1280" fetchpriority="high"
                     className="absolute inset-0 -z-10 h-full w-full object-cover opacity-40" />
                <div className="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/95 via-ink-950/75 to-ink-950/30" />
                <Container className="py-20 sm:py-28 lg:py-32">
                    <div className="max-w-2xl">
                        <p className="inline-flex items-center gap-2 rounded-full border border-brand-400/40 bg-brand-900/40 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-brand-200">
                            <BadgeCheck size={14} aria-hidden /> {content.hero_badge}
                        </p>
                        <h1 className="mt-6 text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                            {content.hero_title}
                        </h1>
                        <p className="mt-6 max-w-xl text-lg leading-relaxed text-ink-100">
                            {content.hero_subtitle}
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
                        <Eyebrow>{content.about_eyebrow}</Eyebrow>
                        <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                            {content.about_title}
                        </h2>
                        <div className="prose-nymak mt-5">
                            <p>{content.about_p1}</p>
                            <p>{content.about_p2}</p>
                        </div>
                        <div className="mt-6 flex flex-wrap gap-3">
                            <ButtonLink href="/about" variant="outline">Our Story <ArrowRight size={15} aria-hidden /></ButtonLink>
                            <ButtonLink href="/manufacturing" variant="ghost">See our facility</ButtonLink>
                        </div>
                    </div>
                    <div className="relative">
                        <img src={`/${content.about_image}`} alt="Nymak Pharma manufacturing plant, Mundra"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="absolute -bottom-5 -left-4 rounded-2xl bg-brand-700 px-5 py-4 text-white shadow-card sm:-left-6">
                            <p className="text-2xl font-extrabold">Since {site.founded || '1998'}</p>
                            <p className="text-xs font-semibold uppercase tracking-wider text-brand-200">Mundra, Gujarat, India</p>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Product categories */}
            <section className="bg-ink-50 py-16 sm:py-24">
                <Container>
                    <SectionHeading eyebrow={content.portfolio_eyebrow} align="center"
                        title={content.portfolio_title}
                        lead={content.portfolio_lead} />
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
                            <SectionHeading eyebrow={content.brands_eyebrow}
                                title={content.brands_title}
                                lead={content.brands_lead} />
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
                        <Eyebrow>{content.quality_eyebrow}</Eyebrow>
                        <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                            {content.quality_title}
                        </h2>
                        <p className="mt-4 text-lg leading-relaxed text-ink-600">
                            {content.quality_body}
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
                        <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300">{content.global_eyebrow}</p>
                        <h2 className="text-3xl font-extrabold tracking-tight sm:text-4xl">
                            {content.global_title}
                        </h2>
                        <p className="mt-4 text-lg leading-relaxed text-ink-200">
                            {content.global_body}
                        </p>
                        <ButtonLink href="/global-presence" variant="primary" className="mt-6">
                            Explore our markets <Globe2 size={16} aria-hidden />
                        </ButtonLink>
                    </div>
                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        {markets.map((m) => (
                            <div key={m.name} className="flex items-center gap-2 rounded-xl border border-ink-700 bg-ink-900 px-4 py-3 text-sm font-semibold">
                                <MapPin size={14} className="shrink-0 text-brand-400" aria-hidden /> {m.name}
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
                        <SectionHeading eyebrow={content.testimonials_eyebrow} align="center" title={content.testimonials_title} />
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
            {clients.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/60 py-14">
                    <Container>
                        <p className="text-center text-xs font-bold uppercase tracking-[0.2em] text-ink-500">
                            {content.clients_lead}
                        </p>
                        <div className="mt-8 grid grid-cols-3 items-center gap-6 sm:grid-cols-4 lg:grid-cols-7">
                            {clients.map((c) => (
                                <img key={c.name} src={`/${c.image}`} alt={`${c.name} — Nymak Pharma client`}
                                     width="200" height="120" loading="lazy"
                                     className="mx-auto h-12 w-auto object-contain opacity-80 transition-opacity hover:opacity-100" />
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* FAQs */}
            {faqs?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container className="grid gap-10 lg:grid-cols-[1fr_1.4fr]">
                        <div>
                            <Eyebrow>{content.faq_eyebrow}</Eyebrow>
                            <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">
                                {content.faq_title}
                            </h2>
                            <p className="mt-4 text-ink-600">
                                {content.faq_lead}
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
                            <SectionHeading eyebrow={content.journal_eyebrow} title={content.journal_title} />
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
                            {content.cta_title}
                        </h2>
                        <p className="mt-2 max-w-xl text-brand-100">
                            {content.cta_body}
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
