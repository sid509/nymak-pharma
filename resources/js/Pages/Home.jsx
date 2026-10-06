import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { ArrowRight, ArrowUpRight, Award, BadgeCheck, Container as ContainerIcon, Factory, Globe2, HeartPulse, MapPin, Pill, Quote } from 'lucide-react';
import { Reveal, useScrollProgress } from '../Components/Motion';
import Accordion from '../Components/Accordion';
import { CategoryCard, CategoryIcon, PostCard, ProductCard } from '../Components/Cards';
import { ButtonLink, Container, CountryFlag, Eyebrow, SectionHeading, Stat, WhatsAppIcon } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

/**
 * Home — a company page, not a catalogue. Products are reached through the
 * category cards; every section can be toggled and its copy edited from
 * Admin → Page content → Home.
 */
export default function Home({ seo, categories, featuredProducts = [], testimonials, certifications, posts, faqs, stats, clients = [], markets = [], content: c }) {
    const { site } = usePage().props;
    const [parallaxRef, parallax] = useScrollProgress();
    const parallaxY = Math.round((parallax - 0.5) * 40); // ±20px drift; stays inside the image's overscan
    const [segment, setSegment] = useState(0);
    const activeCat = categories[segment] || categories[0];

    return (
        <SiteLayout>
            {/* Hero — full-bleed facility image, blended by a directional scrim + bottom fade */}
            <section ref={parallaxRef} className="relative overflow-hidden">
                {/* Image drifts gently on scroll (±20px, covered by the 12% overscan) */}
                <div className="absolute inset-0 will-change-transform"
                     style={{ transform: `translateY(${parallaxY}px) scale(1.12)` }}>
                    <img src={`/${c.hero_image}`} alt="Nymak Pharma facility, Mundra, Gujarat"
                         width="1920" height="1280" fetchPriority="high"
                         className="h-full w-full object-cover" />
                </div>
                {/* Scrim — dark on the text side, thinning right so the photo reads through */}
                <div className="absolute inset-0 bg-gradient-to-r from-ink-950/85 via-ink-950/50 to-ink-950/15" aria-hidden />
                {/* Bottom blend into the page so the section has no hard photographic edge */}
                <div className="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-white to-transparent" aria-hidden />

                <Container className="relative flex min-h-[30rem] items-center py-24 sm:min-h-[34rem] sm:py-28 lg:min-h-[38rem] lg:py-32">
                    <div className="enter max-w-2xl">
                        <p className="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-1.5 t-eyebrow text-white backdrop-blur-sm">
                            <BadgeCheck size={14} className="text-brand-300" aria-hidden /> {c.hero_badge}
                        </p>
                        <h1 className="mt-6 t-hero text-balance text-white">
                            {c.hero_title}
                        </h1>
                        <p className="mt-6 max-w-xl t-lead text-white/80">
                            {c.hero_subtitle}
                        </p>
                        <div className="mt-8 flex flex-wrap gap-3">
                            {c.hero_primary_label && <ButtonLink href={c.hero_primary_url || '/products'}>{c.hero_primary_label} <ArrowRight size={16} className="btn-arrow" aria-hidden /></ButtonLink>}
                            {c.hero_secondary_label && <ButtonLink href={c.hero_secondary_url || '/contact'} variant="outlineLight">{c.hero_secondary_label}</ButtonLink>}
                        </div>
                    </div>
                </Container>
            </section>

            {/* Stats — floating card that lifts over the hero/about seam */}
            {c.show_stats && (
                <section className="relative z-10 -mt-6 sm:-mt-8">
                    <Container>
                        <Reveal>
                            <div className="grid grid-cols-2 gap-x-4 gap-y-6 rounded-3xl border border-ink-100 bg-white px-6 py-8 shadow-card sm:px-8 lg:grid-cols-4">
                                <Stat value={stats.years} label={c.stats_years_label} tone="light" icon={HeartPulse}
                                      className="rounded-2xl px-3 py-2 transition-[background-color,transform] duration-200 ease-out hover:-translate-y-0.5 hover:bg-brand-50/70" />
                                <Stat value={stats.countries} label={c.stats_countries_label} tone="light" icon={Globe2}
                                      className="rounded-2xl px-3 py-2 transition-[background-color,transform] duration-200 ease-out hover:-translate-y-0.5 hover:bg-brand-50/70 lg:border-l lg:border-ink-100 lg:pl-8" />
                                <Stat value={stats.containers_fy} label={c.stats_containers_label} tone="light" icon={ContainerIcon}
                                      className="rounded-2xl px-3 py-2 transition-[background-color,transform] duration-200 ease-out hover:-translate-y-0.5 hover:bg-brand-50/70 lg:border-l lg:border-ink-100 lg:pl-8" />
                                <Stat value={stats.products} label={c.stats_products_label} tone="light" icon={Pill}
                                      className="rounded-2xl px-3 py-2 transition-[background-color,transform] duration-200 ease-out hover:-translate-y-0.5 hover:bg-brand-50/70 lg:border-l lg:border-ink-100 lg:pl-8" />
                            </div>
                        </Reveal>
                    </Container>
                </section>
            )}

            {/* About preview */}
            {c.show_about && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <div className="mx-auto mb-10 max-w-4xl text-center lg:mb-14">
                            <Eyebrow center>{c.about_eyebrow}</Eyebrow>
                            <h2 className="t-h2 text-balance text-gradient font-bold text-3xl lg:text-[2.625rem]">{c.about_title}</h2>
                        </div>
                        <div className="grid items-center gap-10 lg:grid-cols-2">
                        <div className="lg:order-2">
                            <div className="prose-nymak">
                                <p>{c.about_p1}</p>
                                <p>{c.about_p2}</p>
                            </div>
                            <div className="mt-6 flex flex-wrap gap-3">
                                {c.about_cta_label && <ButtonLink href="/about" variant="outline">{c.about_cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>}
                                {c.about_cta2_label && (
                                    <ButtonLink href="/manufacturing" variant="ghost"
                                                className="rounded-full border border-ink-200 px-6 py-2.5 transition-[border-color,color,background-color] duration-200 hover:border-brand-500 hover:bg-brand-50/60 hover:text-brand-800">
                                        <Factory size={15} className="text-brand-600" aria-hidden /> {c.about_cta2_label}
                                    </ButtonLink>
                                )}
                            </div>
                        </div>
                        <div className="relative">
                            {c.about_image && c.about_image !== c.hero_image ? (
                                <>
                                    <Reveal variant="media" className="rounded-3xl shadow-card">
                                        <img src={`/${c.about_image}`} alt="Nymak Pharma manufacturing plant, Mundra"
                                             width="960" height="640" loading="lazy"
                                             className="w-full object-cover" />
                                    </Reveal>
                                    <div className="absolute -bottom-5 -left-4 rounded-2xl bg-brand-700 px-5 py-4 text-white shadow-card sm:-left-6">
                                        <p className="text-2xl font-bold">Since {site.founded || '1998'}</p>
                                        <p className="t-caption uppercase tracking-[0.04em] text-brand-200">{c.about_badge_caption}</p>
                                    </div>
                                </>
                            ) : (
                                /* Same photo as the hero — show a company fact panel instead of repeating it */
                                <Reveal>
                                    <div className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-800 via-brand-900 to-ink-950 p-8 text-white shadow-card sm:p-10">
                                        <div className="absolute -right-16 -top-16 h-56 w-56 rounded-full border border-white/10" aria-hidden />
                                        <div className="absolute -bottom-20 -left-10 h-44 w-44 rounded-full border border-white/10" aria-hidden />
                                        <p className="t-eyebrow text-brand-300">{c.about_badge_caption}</p>
                                        <p className="mt-3 text-3xl font-bold tracking-tight">Since {site.founded || '1998'}</p>
                                        <ul className="mt-8 space-y-5 border-t border-white/15 pt-8">
                                            <li className="flex items-start gap-3">
                                                <Factory size={18} className="mt-0.5 shrink-0 text-brand-300" aria-hidden />
                                                <div>
                                                    <p className="font-semibold">{site.address.city}, {site.address.country}</p>
                                                    <p className="mt-0.5 text-sm text-ink-200">Head office &amp; manufacturing facility</p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-3">
                                                <BadgeCheck size={18} className="mt-0.5 shrink-0 text-brand-300" aria-hidden />
                                                <div>
                                                    <p className="font-semibold">WHO-GMP certified</p>
                                                    <p className="mt-0.5 text-sm text-ink-200">ISO 13485 · in-house QC/QA &amp; regulatory teams</p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-3">
                                                <Globe2 size={18} className="mt-0.5 shrink-0 text-brand-300" aria-hidden />
                                                <div>
                                                    <p className="font-semibold">{stats.countries} export markets</p>
                                                    <p className="mt-0.5 text-sm text-ink-200">{stats.products} products across five segments</p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-3">
                                                <Award size={18} className="mt-0.5 shrink-0 text-brand-300" aria-hidden />
                                                <div>
                                                    <p className="font-semibold">Star Export House</p>
                                                    <p className="mt-0.5 text-sm text-ink-200">Government of India certified exporter</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </Reveal>
                            )}
                        </div>
                        </div>
                    </Container>
                </section>
            )}

            {/* Product categories — the way into the catalogue */}
            {c.show_categories && categories.length > 0 && (
                <section className="bg-ink-50 py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow={c.portfolio_eyebrow} align="center"
                            title={c.portfolio_title}
                            lead={c.portfolio_lead} />

                        {/* Explorer — hover/focus a segment to preview it; click goes straight to the landing page */}
                        <div className="mt-12 hidden gap-10 lg:grid lg:grid-cols-[1.1fr_1fr] lg:gap-14">
                            <div className="self-start border-t border-ink-200/70">
                                {categories.map((cat, i) => (
                                    <Link key={cat.id} href={`/product/${cat.slug}`}
                                          data-segment={cat.slug}
                                          onMouseEnter={() => setSegment(i)}
                                          onFocus={() => setSegment(i)}
                                          className={`group relative flex items-center gap-4 border-b border-ink-200/70 px-2 py-5 transition-colors duration-200 sm:px-4 ${
                                              segment === i ? 'bg-white' : 'hover:bg-white/70'
                                          }`}>
                                        <span aria-hidden className={`absolute bottom-3 left-0 top-3 w-0.5 rounded-full bg-brand-600 transition-opacity duration-200 ${segment === i ? 'opacity-100' : 'opacity-0'}`} />
                                        <span className={`t-caption font-bold tabular-nums transition-colors ${segment === i ? 'text-brand-600' : 'text-ink-300'}`}>
                                            {String(i + 1).padStart(2, '0')}
                                        </span>
                                        <span className={`inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border transition-colors duration-200 ${
                                            segment === i ? 'border-brand-200 bg-brand-50 text-brand-700' : 'border-ink-200/60 bg-white text-ink-500'
                                        }`}>
                                            <CategoryIcon name={cat.icon} size={20} />
                                        </span>
                                        <div className="min-w-0 flex-1">
                                            <h3 className={`t-h4 truncate transition-colors ${segment === i ? 'text-ink-950' : 'text-ink-800'}`}>{cat.name}</h3>
                                            <p className="mt-0.5 t-caption tabular-nums text-ink-400">{cat.products_count} products</p>
                                        </div>
                                        <ArrowRight size={18} aria-hidden
                                            className={`shrink-0 transition-[opacity,transform] duration-200 ${
                                                segment === i ? 'translate-x-0 text-brand-600 opacity-100' : '-translate-x-1 text-ink-300 opacity-0'
                                            }`} />
                                    </Link>
                                ))}
                            </div>
                            <div className="self-start lg:sticky lg:top-28">
                                <div key={activeCat.id}
                                     className="explorer-panel relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-800 via-brand-900 to-ink-950 p-8 text-white shadow-card sm:p-10">
                                    <div className="absolute -right-16 -top-16 h-56 w-56 rounded-full border border-white/10" aria-hidden />
                                    <div className="absolute -bottom-20 -left-10 h-44 w-44 rounded-full border border-white/10" aria-hidden />
                                    <span className="inline-flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-brand-200">
                                        <CategoryIcon name={activeCat.icon} size={26} />
                                    </span>
                                    <h3 className="mt-5 t-h3">{activeCat.name}</h3>
                                    <p className="mt-1 t-caption tabular-nums text-brand-300">{activeCat.products_count} products</p>
                                    {activeCat.intro && <p className="mt-4 text-sm leading-relaxed text-ink-200">{activeCat.intro}</p>}
                                    {activeCat.samples?.length > 0 && (
                                        <div className="mt-6 flex items-center gap-2.5">
                                            {activeCat.samples.map((s) => (
                                                <Link key={s.slug} href={`/product/${activeCat.slug}/${s.slug}`} title={s.name}
                                                      className="group/thumb">
                                                    <img src={`/${s.image}`} alt={s.name} width="96" height="96" loading="lazy"
                                                         className="h-14 w-14 rounded-xl border border-white/15 bg-white object-contain p-1.5 transition-[transform,border-color] duration-200 ease-out group-hover/thumb:-translate-y-0.5 group-hover/thumb:border-white/40" />
                                                </Link>
                                            ))}
                                            <span className="t-caption text-ink-400">Registered products</span>
                                        </div>
                                    )}
                                    <div className="mt-7 flex flex-wrap gap-3">
                                        <ButtonLink href={`/product/${activeCat.slug}`} variant="light">
                                            {c.portfolio_card_label} <ArrowRight size={15} className="btn-arrow" aria-hidden />
                                        </ButtonLink>
                                        <ButtonLink href={`/product/${activeCat.slug}/products`} variant="outlineLight">Product list</ButtonLink>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Compact cards on smaller viewports */}
                        <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:hidden">
                            {categories.map((cat, i) => (
                                <Reveal key={cat.id} delay={i * 60}>
                                    <CategoryCard category={cat} index={i} href={`/product/${cat.slug}`} label={c.portfolio_card_label} />
                                </Reveal>
                            ))}
                        </div>
                        {c.portfolio_cta_label && (
                            <div className="mt-10 text-center">
                                <ButtonLink href="/products" variant="outline">{c.portfolio_cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                            </div>
                        )}
                    </Container>
                </section>
            )}

            {/* Branded products — off by default; admin can switch it on */}
            {c.show_brands && featuredProducts.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow={c.brands_eyebrow} title={c.brands_title} lead={c.brands_lead} />
                        <div className="mt-10 grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                            {featuredProducts.map((p, i) => (
                                <Reveal key={p.id} delay={Math.min(i * 50, 200)}>
                                    <ProductCard product={p} url={`/product/${p.category.slug}/${p.slug}`} />
                                </Reveal>
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* Quality & certifications strip */}
            {c.show_quality && (
                <section className="border-y border-ink-100 bg-white py-16 sm:py-20">
                    <Container>
                        <SectionHeading eyebrow={c.quality_eyebrow} title={c.quality_title} lead={c.quality_body} className="mb-12" />
                        {/* Carousel — auto-scrolls, pauses on hover/focus */}
                        <div className="marquee -mx-4 sm:-mx-6" aria-label="Certifications carousel">
                            {[0, 1].map((track) => (
                                <div key={track} className="marquee-track marquee-track--certs" aria-hidden={track === 1}>
                                    {certifications.map((cert) => (
                                        <div key={cert.name}
                                             className="flex w-64 shrink-0 flex-col items-center rounded-3xl border border-ink-100 bg-white px-8 py-8 text-center shadow-card transition-[transform,border-color,box-shadow] duration-200 ease-out hover:-translate-y-1 hover:border-brand-200 hover:shadow-card-hover sm:w-72">
                                            {cert.image ? (
                                                <img src={`/${cert.image}`} alt={track === 0 ? `${cert.name} certification` : ''} width="200" height="200" loading="lazy"
                                                     className="h-28 w-auto object-contain" />
                                            ) : (
                                                <Award size={56} className="text-brand-600" aria-hidden />
                                            )}
                                            <p className="mt-5 font-semibold text-ink-900">{cert.name}</p>
                                            {cert.issuer && <p className="mt-1 t-caption text-ink-500">{cert.issuer}</p>}
                                        </div>
                                    ))}
                                </div>
                            ))}
                        </div>
                        {c.quality_cta_label && (
                            <div className="mt-10 text-center">
                                <ButtonLink href="/quality-certifications" variant="outline">
                                    {c.quality_cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden />
                                </ButtonLink>
                            </div>
                        )}
                    </Container>
                </section>
            )}

            {/* Global presence */}
            {c.show_global && (
                <section className="relative overflow-hidden bg-ink-950 py-16 text-white sm:py-24">
                    <div className="absolute -right-24 -top-24 h-80 w-80 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute -bottom-32 -left-16 h-72 w-72 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(12,165,235,0.14),transparent_55%)]" aria-hidden />
                    <Container className="relative">
                        <div className="mx-auto max-w-2xl text-center">
                            <p className="mb-3 flex items-center justify-center gap-2.5 t-eyebrow text-gold-400">
                                <span className="h-px w-6 bg-gold-400" aria-hidden />{c.global_eyebrow}<span className="h-px w-6 bg-gold-400" aria-hidden />
                            </p>
                            <h2 className="t-h2">{c.global_title}</h2>
                            <p className="mt-4 t-lead text-pretty text-ink-200">{c.global_body}</p>
                            {c.global_cta_label && (
                                <div className="mt-7">
                                    <ButtonLink href="/global-presence" variant="primary">
                                        {c.global_cta_label} <Globe2 size={16} aria-hidden />
                                    </ButtonLink>
                                </div>
                            )}
                        </div>
                        <div className="mx-auto mt-12 grid max-w-4xl grid-cols-2 gap-3 sm:grid-cols-3">
                            {markets.map((m, i) => (
                                <Reveal key={m.name} delay={Math.min(i * 60, 300)}>
                                <Link href={`/global-presence#${m.slug}`}
                                      className="group flex h-full items-center gap-3 rounded-xl border border-white/10 bg-white/[0.04] px-4 py-3 backdrop-blur-sm transition-[transform,border-color,background-color] duration-200 ease-out hover:-translate-y-0.5 hover:border-gold-400/50 hover:bg-white/[0.08] focus:outline-none focus-visible:ring-2 focus-visible:ring-gold-400">
                                    <CountryFlag iso={m.iso_code} className="h-5 w-7 ring-white/20" iconClass="h-5 w-5 text-gold-400" />
                                    <span className="min-w-0 flex-1">
                                        <span className="block truncate text-sm font-semibold">{m.name}</span>
                                        {m.region && <span className="block truncate text-[11px] font-medium uppercase tracking-[0.06em] text-ink-400">{m.region}</span>}
                                    </span>
                                    <ArrowUpRight size={14} className="shrink-0 text-gold-400 opacity-0 transition-opacity duration-200 group-hover:opacity-100" aria-hidden />
                                </Link>
                                </Reveal>
                            ))}
                            {c.global_more_label && (
                                <Link href="/global-presence"
                                      className="group flex h-full items-center gap-3 rounded-xl border border-brand-400/40 bg-brand-500/10 px-4 py-3 transition-[transform,background-color] duration-200 ease-out hover:-translate-y-0.5 hover:bg-brand-500/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300">
                                    <Globe2 size={18} className="shrink-0 text-brand-300" aria-hidden />
                                    <span className="flex-1 text-sm font-semibold text-brand-200">{c.global_more_label}</span>
                                    <ArrowUpRight size={14} className="shrink-0 text-brand-300 transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:translate-x-0.5" aria-hidden />
                                </Link>
                            )}
                        </div>
                    </Container>
                </section>
            )}

            {/* Testimonials */}
            {c.show_testimonials && testimonials?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow={c.testimonials_eyebrow} align="center" title={c.testimonials_title} />
                        <div className="mt-12 grid gap-5 md:grid-cols-3">
                            {testimonials.map((t, i) => (
                                <Reveal key={t.name} delay={i * 80}>
                                <figure className="flex h-full flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-[transform,box-shadow] duration-200 ease-out hover:-translate-y-0.5 hover:shadow-lg">
                                    <Quote size={24} className="text-brand-500" aria-hidden />
                                    <blockquote className="mt-4 flex-1 text-sm leading-relaxed text-ink-700">{t.quote}</blockquote>
                                    <figcaption className="mt-5 border-t border-ink-100 pt-4">
                                        <p className="text-sm font-semibold text-ink-900">{t.name}</p>
                                        <p className="text-xs font-semibold text-ink-500">{t.country}</p>
                                    </figcaption>
                                </figure>
                                </Reveal>
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* Client logos */}
            {c.show_clients && clients.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/60 py-14">
                    <Container>
                        <p className="t-eyebrow text-center text-ink-500">
                            {c.clients_lead}
                        </p>
                        <div className="marquee mt-8" aria-label="Our clients">
                            {[0, 1].map((track) => (
                                <div key={track} className="marquee-track" aria-hidden={track === 1}>
                                    {clients.map((cl) => (
                                        <img key={cl.name} src={`/${cl.image}`} alt={track === 0 ? `${cl.name} — Nymak Pharma client` : ''}
                                             width="200" height="120" loading="lazy"
                                             className="h-12 w-auto shrink-0 object-contain opacity-80 transition-opacity hover:opacity-100" />
                                    ))}
                                </div>
                            ))}
                        </div>
                    </Container>
                </section>
            )}

            {/* FAQs */}
            {c.show_faqs && faqs?.length > 0 && (
                <section className="py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow={c.faq_eyebrow} title={c.faq_title} lead={c.faq_lead} className="mb-10" />
                        <div className="mx-auto max-w-3xl">
                            <Accordion items={faqs} />
                            {c.faq_cta_label && (
                                <div className="mt-8 text-center">
                                    <ButtonLink href="/faqs" variant="outline">{c.faq_cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                </div>
                            )}
                        </div>
                    </Container>
                </section>
            )}

            {/* Latest posts */}
            {c.show_journal && posts?.length > 0 && (
                <section className="bg-ink-50 py-16 sm:py-24">
                    <Container>
                        <SectionHeading eyebrow={c.journal_eyebrow} title={c.journal_title} />
                        <div className="mt-10 grid gap-5 md:grid-cols-3">
                            {posts.map((p) => <PostCard key={p.slug} post={p} />)}
                        </div>
                        {c.journal_cta_label && (
                            <div className="mt-10 text-center">
                                <ButtonLink href="/blog" variant="outline">{c.journal_cta_label} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                            </div>
                        )}
                    </Container>
                </section>
            )}

            {/* CTA */}
            {c.show_cta && (
                <section className="relative overflow-hidden bg-gradient-to-b from-brand-800 to-brand-950">
                    <div className="absolute -left-20 -top-24 h-72 w-72 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute -bottom-28 -right-16 h-80 w-80 rounded-full border border-white/10" aria-hidden />
                    <Container className="relative py-16 text-center sm:py-20">
                        <h2 className="t-h2 mx-auto max-w-2xl text-balance text-white">
                            {c.cta_title}
                        </h2>
                        <p className="mx-auto mt-4 max-w-xl t-lead text-brand-100">
                            {c.cta_body}
                        </p>
                        <div className="mt-8 flex flex-wrap justify-center gap-3">
                            <ButtonLink href="/contact" variant="light">{c.cta_primary_label} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                            {c.show_cta_whatsapp && c.cta_whatsapp_label && site.whatsapp && (
                                <ButtonLink href={`https://wa.me/${site.whatsapp}`} external variant="outlineLight">
                                    <WhatsAppIcon size={15} /> {c.cta_whatsapp_label}
                                </ButtonLink>
                            )}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
