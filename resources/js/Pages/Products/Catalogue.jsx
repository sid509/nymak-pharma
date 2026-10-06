import { Link } from '@inertiajs/react';
import { ArrowLeft, ArrowRight, Search } from 'lucide-react';
import { useMemo, useState } from 'react';
import { ProductCard } from '../../Components/Cards';
import SpecTable from '../../Components/SpecTable';
import { ButtonLink, Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';
import { CategoryNav, fill } from './Category';

const groupId = (name) => `group-${name.replace(/\W+/g, '-').toLowerCase()}`;

/**
 * Full product list for a category — grouped spec tables with in-page
 * search. Rows with a detail page link through; everything else is listed
 * for completeness (and SEO) without a buy/quote affordance.
 */
export default function ProductsCatalogue({ seo, category, groups, siblings, content: c }) {
    const [query, setQuery] = useState('');
    const isKitCategory = category.slug === 'rapid-diagnostic-kits';
    const vars = { category: category.name, count: category.products_count, query };

    // Client-side filter across all groups — keeps the table usable at 200+ rows.
    const filtered = useMemo(() => {
        if (!query.trim()) return groups;
        const q = query.toLowerCase();
        return groups
            .map((g) => ({
                ...g,
                products: g.products.filter((p) =>
                    [p.name, p.strength, p.therapeutic_group].filter(Boolean).join(' ').toLowerCase().includes(q)),
            }))
            .filter((g) => g.products.length > 0);
    }, [groups, query]);

    const branded = groups.find((g) => g.name === 'Nymak Branded Range');
    const catalog = filtered.filter((g) => g.name !== 'Nymak Branded Range');

    return (
        <SiteLayout>
            <PageHero eyebrow={c.eyebrow}
                breadcrumbs={[['Home', '/'], ['Products', '/products'], [category.name, category.url], ['Product list']]}
                title={fill(c.title, vars)} lead={c.lead} />

            <section className="py-14 sm:py-20">
                <Container>
                    <div className="grid gap-12 lg:grid-cols-[240px_1fr]">
                        <aside className="lg:sticky lg:top-28 lg:self-start">
                            <CategoryNav siblings={siblings} current={category.slug} title="Categories" allLabel="All Products" />
                            <Link href={category.url} className="mt-3 inline-flex items-center gap-1.5 px-3 text-sm font-semibold text-brand-700 hover:underline">
                                <ArrowLeft size={14} aria-hidden /> {fill(c.back_label, vars)}
                            </Link>
                        </aside>

                        <div className="min-w-0">
                            {branded && (
                                <div className="mb-12">
                                    <h2 className="mb-5 t-h3 text-ink-900">{c.branded_title}</h2>
                                    <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        {branded.products.filter((p) => p.image).map((p) => (
                                            <ProductCard key={p.slug} product={p} url={p.url} />
                                        ))}
                                    </div>
                                </div>
                            )}

                            {category.products_count > 8 && (
                                <div className="mb-8">
                                    <label htmlFor="product-search" className="mb-2 block text-xs font-semibold uppercase tracking-[0.04em] text-ink-600">
                                        {fill(c.search_label, vars)}
                                    </label>
                                    <div className="relative max-w-md">
                                        <Search size={16} className="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-ink-400" aria-hidden />
                                        <input id="product-search" type="search" value={query}
                                               onChange={(e) => setQuery(e.target.value)} placeholder={c.search_placeholder}
                                               className="w-full rounded-lg border border-ink-200 bg-white py-2.5 pl-10 pr-4 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" />
                                    </div>
                                </div>
                            )}

                            <div className="space-y-10">
                                {catalog.map((g) => (
                                    <section key={g.name} id={groupId(g.name)} aria-labelledby={`${groupId(g.name)}-h`} className="scroll-mt-28">
                                        <h2 id={`${groupId(g.name)}-h`} className="mb-4 t-h3 text-ink-900">{g.name}</h2>
                                        <SpecTable products={g.products} mode={isKitCategory ? 'specimen' : 'strength'} />
                                    </section>
                                ))}
                            </div>

                            {filtered.length === 0 && (
                                <div className="rounded-2xl border border-dashed border-ink-200 bg-ink-50/50 p-10 text-center">
                                    <p className="font-semibold text-ink-700">{fill(c.empty_title, vars)}</p>
                                    <p className="mt-1 text-sm text-ink-500">{c.empty_body}</p>
                                </div>
                            )}

                            {c.show_cta && (
                                <div className="mt-14 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 p-8 text-white">
                                    <h2 className="t-h3">{fill(c.cta_title, vars)}</h2>
                                    <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">{c.cta_body}</p>
                                    <ButtonLink href="/contact" variant="light" className="mt-5">{c.cta_button} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                </div>
                            )}
                        </div>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
