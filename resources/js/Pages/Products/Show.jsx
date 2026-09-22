import { Link } from '@inertiajs/react';
import { Globe2, MapPin } from 'lucide-react';
import { ProductCard } from '../../Components/Cards';
import { Breadcrumbs, ButtonLink, Container } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function ProductsShow({ seo, product, category, related }) {
    return (
        <SiteLayout>
            <section className="border-b border-ink-100 bg-gradient-to-b from-brand-50/60 to-white">
                <Container className="py-14 sm:py-16">
                    <Breadcrumbs className="mb-8" items={[
                        ['Home', '/'], ['Products', '/products'],
                        [category.name, `/products/${category.slug}`], [product.name],
                    ]} />

                    <div className="grid items-start gap-10 lg:grid-cols-2">
                        <div className="overflow-hidden rounded-3xl border border-ink-100 bg-white shadow-card">
                            {product.image ? (
                                <img src={`/${product.image}`} alt={`${product.name} — Nymak Pharma ${product.market?.name || ''}`.trim()}
                                     width="800" height="600" fetchpriority="high"
                                     className="w-full object-contain" />
                            ) : (
                                <div className="flex aspect-[4/3] items-center justify-center bg-ink-50 text-ink-300">Nymak Pharma</div>
                            )}
                        </div>

                        <div>
                            <p className="text-xs font-bold uppercase tracking-[0.2em] text-brand-700">{category.name}</p>
                            <h1 className="mt-2 text-3xl font-extrabold tracking-tight text-ink-950 sm:text-4xl">{product.name}</h1>
                            <p className="mt-4 text-lg leading-relaxed text-ink-600">{product.description}</p>

                            <dl className="mt-6 space-y-3 rounded-2xl border border-ink-100 bg-white p-5">
                                {product.strength && (
                                    <div className="flex gap-4 text-sm"><dt className="w-28 shrink-0 font-bold text-ink-500">Strength</dt><dd className="text-ink-900">{product.strength}</dd></div>
                                )}
                                {product.pack_size && (
                                    <div className="flex gap-4 text-sm"><dt className="w-28 shrink-0 font-bold text-ink-500">Pack Size</dt><dd className="text-ink-900">{product.pack_size}</dd></div>
                                )}
                                {product.market && (
                                    <div className="flex gap-4 text-sm">
                                        <dt className="w-28 shrink-0 font-bold text-ink-500">Marketed in</dt>
                                        <dd>
                                            <Link href={`/global-presence/${product.market.slug}`} className="inline-flex items-center gap-1 font-semibold text-brand-700 hover:underline">
                                                <MapPin size={13} aria-hidden /> {product.market.name}
                                            </Link>
                                        </dd>
                                    </div>
                                )}
                                <div className="flex gap-4 text-sm"><dt className="w-28 shrink-0 font-bold text-ink-500">Standard</dt><dd className="text-ink-900">Manufactured under WHO-GMP conditions</dd></div>
                            </dl>

                            <div className="mt-6 flex flex-wrap gap-3">
                                <ButtonLink href="/contact">Enquire about this product</ButtonLink>
                                <ButtonLink href={`/products/${category.slug}`} variant="outline">Back to {category.name}</ButtonLink>
                            </div>
                        </div>
                    </div>
                </Container>
            </section>

            {related?.length > 0 && (
                <section className="py-14 sm:py-16">
                    <Container>
                        <h2 className="text-2xl font-extrabold tracking-tight text-ink-900">
                            Related products
                        </h2>
                        <div className="mt-8 grid grid-cols-2 gap-5 md:grid-cols-4">
                            {related.map((p) => <ProductCard key={p.url} product={p} url={p.url} />)}
                        </div>
                    </Container>
                </section>
            )}

            <section className="border-t border-ink-100 bg-ink-50/50 py-12">
                <Container className="flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-center">
                    <div className="flex items-start gap-3">
                        <Globe2 size={24} className="mt-1 shrink-0 text-brand-700" aria-hidden />
                        <div>
                            <h2 className="text-lg font-extrabold text-ink-900">Export & registration support</h2>
                            <p className="mt-1 max-w-xl text-sm text-ink-600">
                                Our regulatory team supports dossiers, market-specific labelling and registration
                                requirements. Tell us your destination market and required quantities.
                            </p>
                        </div>
                    </div>
                    <ButtonLink href="/contact">Contact exports team</ButtonLink>
                </Container>
            </section>
        </SiteLayout>
    );
}
