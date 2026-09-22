import { CategoryCard, ProductCard } from '../../Components/Cards';
import { ButtonLink, Container, PageHero, SectionHeading } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function ProductsIndex({ seo, categories, branded }) {
    return (
        <SiteLayout>
            <PageHero eyebrow="Our Products" breadcrumbs={[['Home', '/'], ['Products']]}
                title="A pharmaceutical export portfolio built for real-world need"
                lead="Five segments, 300+ line items, one manufacturing standard. Every product below ships under WHO-GMP conditions with registration support for your market." />

            {/* Categories */}
            <section className="py-16 sm:py-20">
                <Container>
                    <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {categories.map((c) => <CategoryCard key={c.id} category={c} href={`/products/${c.slug}`} />)}
                        <div className="flex h-full flex-col justify-center rounded-2xl bg-brand-700 p-6 text-white shadow-card">
                            <h3 className="text-lg font-bold">Need something specific?</h3>
                            <p className="mt-2 text-sm leading-relaxed text-brand-100">
                                Our regulatory team supports custom presentations, pack sizes and market-specific
                                registrations. Tell us what your market needs.
                            </p>
                            <ButtonLink href="/contact" variant="light" className="mt-4 self-start">Send an enquiry</ButtonLink>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Branded range */}
            {branded?.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-16 sm:py-20">
                    <Container>
                        <SectionHeading eyebrow="Branded Portfolio"
                            title="Registered Nymak brands in market"
                            lead="Products marketed under Nymak brand names in West African markets — Alumak, Cefmak, Cipromak, Clavmak and more." />
                        <div className="mt-10 grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                            {branded.map((p) => (
                                <ProductCard key={p.id} product={p} url={`/products/${p.category.slug}/${p.slug}`} />
                            ))}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
