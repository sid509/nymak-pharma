import { Link } from '@inertiajs/react';
import { ArrowRight, ListChecks } from 'lucide-react';
import { CategoryIcon } from '../../Components/Cards';
import { Reveal } from '../../Components/Motion';
import { ButtonLink, Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

/** Fill {category} / {count} placeholders in admin-authored copy. */
export const fill = (text, vars) => String(text ?? '').replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? '');

/** Sibling category nav — shared by the category landing + list pages. */
export function CategoryNav({ siblings, current, title, allLabel }) {
    return (
        <nav aria-label="Product categories" className="rounded-2xl border border-ink-100 bg-white p-3">
            <p className="px-3 pb-2 pt-1 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{title}</p>
            <Link href="/products"
               className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-ink-700 transition-colors hover:bg-ink-50">
                {allLabel}
            </Link>
            {siblings.map((s) => (
                <Link key={s.slug} href={`/product/${s.slug}`} aria-current={s.slug === current ? 'page' : undefined}
                   className={`flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold transition-colors ${
                       s.slug === current ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50'}`}>
                    <CategoryIcon name={s.icon} size={15} />
                    {s.name}
                </Link>
            ))}
        </nav>
    );
}

/**
 * Category landing page — what the range is and who it serves (indexable
 * content), a summary of what it covers, and the way through to the full
 * product list. No tables here: this page sells the category, the list
 * page lists it.
 */
export default function ProductsCategory({ seo, category, groups, siblings, content: c }) {
    const vars = { category: category.name, count: category.products_count };

    return (
        <SiteLayout>
            <PageHero eyebrow={c.eyebrow} breadcrumbs={[['Home', '/'], ['Products', '/products'], [category.name]]}
                title={category.name} lead={category.intro} />

            <section className="py-14 sm:py-20">
                <Container>
                    <div className={`grid gap-12 ${c.show_siblings ? 'lg:grid-cols-[240px_1fr]' : ''}`}>
                        {c.show_siblings && (
                            <aside className="lg:sticky lg:top-28 lg:self-start">
                                <CategoryNav siblings={siblings} current={category.slug} title={c.siblings_title} allLabel={c.siblings_all_label} />
                            </aside>
                        )}

                        <div className="min-w-0">
                            {category.image && (
                                <Reveal variant="media" className="mb-10 rounded-3xl shadow-card">
                                    <img src={`/${category.image}`} alt={`${category.name} — Nymak Pharma`}
                                         width="1200" height="600" fetchPriority="high"
                                         className="aspect-[2/1] w-full object-cover" />
                                </Reveal>
                            )}

                            {/* Indexable body — WYSIWYG from admin, plain description as fallback */}
                            {category.content ? (
                                <div className="prose-nymak max-w-3xl" dangerouslySetInnerHTML={{ __html: category.content }} />
                            ) : category.description ? (
                                <div className="prose-nymak max-w-3xl"><p>{category.description}</p></div>
                            ) : null}

                            {/* What the range covers → link to the full list */}
                            <Reveal>
                                <div className="mt-12 rounded-3xl border border-ink-100 bg-ink-50/60 p-6 sm:p-8">
                                    <p className="text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{c.range_eyebrow}</p>
                                    <h2 className="mt-2 t-h3 text-ink-900">{fill(c.range_title, vars)}</h2>
                                    {c.range_lead && <p className="mt-2 max-w-2xl text-sm leading-relaxed text-ink-600">{c.range_lead}</p>}
                                    {groups.length > 0 && (
                                        <ul className="mt-6 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                                            {groups.map((g) => (
                                                <li key={g.name}>
                                                    <Link href={`${category.catalogue_url}#group-${g.name.replace(/\W+/g, '-').toLowerCase()}`}
                                                          className="group flex items-center justify-between gap-3 rounded-xl border border-ink-100 bg-white px-4 py-3 text-sm font-semibold text-ink-800 transition-colors hover:border-brand-300 hover:text-brand-800">
                                                        <span className="flex items-center gap-2"><ListChecks size={15} className="shrink-0 text-brand-600" aria-hidden />{g.name}</span>
                                                        <span className="shrink-0 rounded-full bg-ink-50 px-2 py-0.5 text-xs font-semibold text-ink-500 group-hover:bg-brand-50 group-hover:text-brand-700">{g.count}</span>
                                                    </Link>
                                                </li>
                                            ))}
                                        </ul>
                                    )}
                                    <ButtonLink href={category.catalogue_url} className="mt-7">
                                        {fill(c.catalogue_label, vars)} <ArrowRight size={16} className="btn-arrow" aria-hidden />
                                    </ButtonLink>
                                </div>
                            </Reveal>

                            {c.show_cta && (
                                <Reveal>
                                    <div className="mt-10 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 p-8 text-white">
                                        <h2 className="t-h3">{fill(c.cta_title, vars)}</h2>
                                        <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">{c.cta_body}</p>
                                        <ButtonLink href="/contact" variant="light" className="mt-5">{c.cta_button} <ArrowRight size={15} className="btn-arrow" aria-hidden /></ButtonLink>
                                    </div>
                                </Reveal>
                            )}
                        </div>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
