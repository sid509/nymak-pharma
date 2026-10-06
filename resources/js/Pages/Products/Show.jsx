import Link from '../../i18n/LocaleLink';
import { ArrowRight, Globe2, MapPin } from 'lucide-react';
import { ProductCard } from '../../Components/Cards';
import { Breadcrumbs, ButtonLink, Container, Eyebrow } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';
import { useT } from '../../i18n/useT';
import { fill } from './Category';

/**
 * Product detail — specification and context, with a contact CTA (no
 * quote/cart affordance: enquiries go through the contact form, which
 * pre-selects this product).
 */
export default function ProductsShow({ seo, product, category, related = [], content: c }) {
    const { t } = useT();
    const vars = { category: category.name, product: product.name };

    return (
        <SiteLayout>
            <section className="border-b border-ink-100 bg-gradient-to-b from-brand-50/60 to-white">
                <Container className="py-14 sm:py-16">
                    <Breadcrumbs className="mb-8" items={[
                        ['Home', '/'], ['Products', '/products'],
                        [category.name, category.url], [product.name],
                    ]} />

                    <div className="grid items-start gap-10 lg:grid-cols-2">
                        <div className="overflow-hidden rounded-3xl border border-ink-100 bg-white shadow-card">
                            {product.image ? (
                                <img src={`/${product.image}`} alt={`${product.name} — Nymak Pharma ${product.market?.name || ''}`.trim()}
                                     width="800" height="600" fetchPriority="high"
                                     className="w-full object-contain" />
                            ) : (
                                <div className="flex aspect-[4/3] items-center justify-center bg-ink-50 text-ink-300">Nymak Pharma</div>
                            )}
                        </div>

                        <div>
                            <Eyebrow>
                                <Link href={category.url} className="underline-offset-2 hover:underline">{category.name}</Link>
                            </Eyebrow>
                            <h1 className="mt-2 t-page text-ink-950">{product.name}</h1>
                            {product.description && <p className="mt-4 t-lead text-ink-600">{product.description}</p>}

                            <dl className="mt-6 divide-y divide-ink-100 rounded-2xl border border-ink-100 bg-white">
                                {product.strength && (
                                    <div className="flex gap-4 px-5 py-3.5 text-sm"><dt className="w-28 shrink-0 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{t('Strength')}</dt><dd className="font-medium tabular-nums text-ink-900">{product.strength}</dd></div>
                                )}
                                {product.pack_size && (
                                    <div className="flex gap-4 px-5 py-3.5 text-sm"><dt className="w-28 shrink-0 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{t('Pack Size')}</dt><dd className="font-medium tabular-nums text-ink-900">{product.pack_size}</dd></div>
                                )}
                                {c.show_market && product.market && (
                                    <div className="flex gap-4 px-5 py-3.5 text-sm">
                                        <dt className="w-28 shrink-0 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{t('Marketed in')}</dt>
                                        <dd>
                                            <Link href={`/global-presence#${product.market.slug}`} className="inline-flex items-center gap-1 font-semibold text-brand-700 underline-offset-2 hover:underline">
                                                <MapPin size={13} aria-hidden /> {product.market.name}
                                            </Link>
                                        </dd>
                                    </div>
                                )}
                                {c.standard_value && (
                                    <div className="flex gap-4 px-5 py-3.5 text-sm"><dt className="w-28 shrink-0 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{c.standard_label}</dt><dd className="font-medium text-ink-900">{c.standard_value}</dd></div>
                                )}
                            </dl>

                            <div className="mt-6 flex flex-wrap gap-3">
                                <ButtonLink href={`/contact?product=${product.slug}`}>{c.cta_button} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                <ButtonLink href={category.url} variant="outline">{fill(c.back_label, vars)}</ButtonLink>
                            </div>
                        </div>
                    </div>
                </Container>
            </section>

            {c.show_related && related.length > 0 && (
                <section className="py-14 sm:py-16">
                    <Container>
                        <h2 className="t-h3 text-ink-900">{c.related_title}</h2>
                        <div className="mt-8 grid grid-cols-2 gap-5 md:grid-cols-4">
                            {related.map((p) => <ProductCard key={p.url} product={p} url={p.url} />)}
                        </div>
                    </Container>
                </section>
            )}

            {c.show_support && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-12">
                    <Container className="flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-center">
                        <div className="flex items-start gap-3">
                            <Globe2 size={24} className="mt-1 shrink-0 text-brand-700" aria-hidden />
                            <div>
                                <h2 className="t-h4 text-ink-900">{c.support_title}</h2>
                                <p className="mt-1 max-w-xl text-sm text-ink-600">{c.support_body}</p>
                            </div>
                        </div>
                        <ButtonLink href="/contact">{c.support_button}</ButtonLink>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
