import { Link } from '@inertiajs/react';
import { Search } from 'lucide-react';
import { useMemo, useState } from 'react';
import { CategoryIcon, ProductCard } from '../../Components/Cards';
import SpecTable from '../../Components/SpecTable';
import { ButtonLink, Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function ProductsCategory({ seo, category, groups, siblings }) {
    const [query, setQuery] = useState('');

    const isKitCategory = category.slug === 'rapid-diagnostic-kits';

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
    const total = groups.reduce((n, g) => n + g.products.length, 0);

    return (
        <SiteLayout>
            <PageHero eyebrow="Products" breadcrumbs={[['Home', '/'], ['Products', '/products'], [category.name]]}
                title={category.name} lead={category.intro} />

            <section className="py-14 sm:py-20">
                <Container>
                    <div className="grid gap-12 lg:grid-cols-[240px_1fr]">
                        {/* Side nav — sibling categories */}
                        <aside className="lg:sticky lg:top-28 lg:self-start">
                            <nav aria-label="Product categories" className="rounded-2xl border border-ink-100 bg-white p-3">
                                <p className="px-3 pb-2 pt-1 text-xs font-bold uppercase tracking-widest text-ink-500">Categories</p>
                                <Link href="/products"
                                   className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-ink-700 transition-colors hover:bg-ink-50">
                                    All Products
                                </Link>
                                {siblings.map((s) => (
                                    <Link key={s.slug} href={`/products/${s.slug}`}
                                       className={`flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold transition-colors ${
                                           s.slug === category.slug ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50'
                                       }`}>
                                        <CategoryIcon name={s.icon} size={15} />
                                        {s.name}
                                    </Link>
                                ))}
                            </nav>
                        </aside>

                        <div>
                            {/* Description — 300+ words of indexable content (requirement #8) */}
                            {category.description && (
                                <div className="prose-nymak mb-10 max-w-3xl">
                                    <p>{category.description}</p>
                                </div>
                            )}

                            {/* Branded range cards */}
                            {branded && (
                                <div className="mb-12">
                                    <h2 className="mb-5 text-xl font-extrabold text-ink-900">Nymak branded range</h2>
                                    <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        {branded.products.filter((p) => p.image).map((p) => (
                                            <ProductCard key={p.slug} product={p} url={p.url} />
                                        ))}
                                    </div>
                                </div>
                            )}

                            {/* Search within catalogue */}
                            {total > 8 && (
                                <div className="mb-8">
                                    <label htmlFor="product-search" className="mb-2 block text-xs font-bold uppercase tracking-wider text-ink-600">
                                        Search this catalogue ({total} products)
                                    </label>
                                    <div className="relative max-w-md">
                                        <Search size={16} className="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-ink-400" aria-hidden />
                                        <input id="product-search" type="search" value={query}
                                               onChange={(e) => setQuery(e.target.value)} placeholder="e.g. ceftriaxone, infusion, tablets…"
                                               className="w-full rounded-lg border border-ink-200 bg-white py-2.5 pl-10 pr-4 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" />
                                    </div>
                                </div>
                            )}

                            {/* Grouped spec tables */}
                            <div className="space-y-10">
                                {catalog.map((g) => (
                                    <section key={g.name} aria-labelledby={`group-${g.name.replace(/\W+/g, '-').toLowerCase()}`}>
                                        <h2 id={`group-${g.name.replace(/\W+/g, '-').toLowerCase()}`}
                                            className="mb-4 text-xl font-extrabold text-ink-900">
                                            {g.name}
                                        </h2>
                                        <SpecTable products={g.products} mode={isKitCategory ? 'specimen' : 'strength'} />
                                    </section>
                                ))}
                            </div>

                            {filtered.length === 0 && (
                                <div className="rounded-2xl border border-dashed border-ink-200 bg-ink-50/50 p-10 text-center">
                                    <p className="font-semibold text-ink-700">No products match “{query}”.</p>
                                    <p className="mt-1 text-sm text-ink-500">Try a generic name or therapeutic class — or ask us directly.</p>
                                </div>
                            )}

                            {/* CTA */}
                            <div className="mt-14 rounded-2xl bg-brand-700 p-8 text-white">
                                <h2 className="text-xl font-extrabold">Sourcing {category.name.toLowerCase()} for your market?</h2>
                                <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                                    We support registration dossiers, market-specific packaging and container
                                    logistics. Send us your requirement and destination market.
                                </p>
                                <ButtonLink href="/contact" variant="light" className="mt-5">Enquire now</ButtonLink>
                            </div>
                        </div>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
