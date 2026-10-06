import { ArrowRight } from 'lucide-react';
import { CategoryCard, ProductCard } from '../../Components/Cards';
import { Reveal } from '../../Components/Motion';
import { ButtonLink, Container, PageHero, SectionHeading } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

/** Products overview — categories first; each card opens its landing page. */
export default function ProductsIndex({ seo, categories, branded = [], content: c }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={c.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Products']]}
                title={c.hero_title}
                lead={c.hero_lead} />

            <section className="py-16 sm:py-20">
                <Container>
                    <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {categories.map((cat, i) => (
                            <Reveal key={cat.id} delay={Math.min(i * 60, 240)}>
                                <CategoryCard category={cat} index={i} href={`/product/${cat.slug}`} label={c.card_label} />
                            </Reveal>
                        ))}
                        {c.show_cta_card && (
                            <Reveal delay={Math.min(categories.length * 60, 300)}>
                                <div className="flex h-full flex-col justify-center rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 p-6 text-white shadow-card">
                                    <h3 className="t-h4">{c.cta_card_title}</h3>
                                    <p className="mt-2 text-sm leading-relaxed text-brand-100">{c.cta_card_body}</p>
                                    <ButtonLink href="/contact" variant="light" className="mt-4 self-start">{c.cta_card_button} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                </div>
                            </Reveal>
                        )}
                    </div>
                </Container>
            </section>

            {c.show_brands && branded.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-16 sm:py-20">
                    <Container>
                        <SectionHeading eyebrow={c.brands_eyebrow} title={c.brands_title} lead={c.brands_lead} />
                        <div className="mt-10 grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                            {branded.map((p) => (
                                <ProductCard key={p.id} product={p} url={`/product/${p.category.slug}/${p.slug}`} />
                            ))}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
