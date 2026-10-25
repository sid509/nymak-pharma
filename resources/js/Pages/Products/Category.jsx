import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowRight, faBorderAll, faChevronRight, faListCheck } from '@fortawesome/free-solid-svg-icons';
import Link from '../../i18n/LocaleLink';

import { CategoryIcon } from '../../Components/Cards';
import { Reveal } from '../../Components/Motion';
import { ButtonLink, Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

/** Fill {category} / {count} placeholders in admin-authored copy. */
export const fill = (text, vars) => String(text ?? '').replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? '');

/** Sibling category nav — shared by the category landing + list pages. */
export function CategoryNav({ siblings, current, title, allLabel }) {
    const itemCls = (active) => `group/navitem flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-semibold transition-all duration-200 ${
        active
            ? 'border-brand-200 bg-brand-50 text-brand-800 shadow-sm'
            : 'border-transparent text-ink-700 hover:border-brand-200 hover:bg-brand-50/70 hover:text-brand-800 hover:shadow-sm'}`;
    const tileCls = (active) => `inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border transition-colors duration-200 ${
        active
            ? 'border-brand-300 bg-white text-brand-700'
            : 'border-ink-100 bg-ink-50 text-ink-500 group-hover/navitem:border-brand-200 group-hover/navitem:bg-white group-hover/navitem:text-brand-700'}`;
    const chevronCls = (active) => `ml-auto shrink-0 transition-[transform,color,opacity] duration-200 ${
        active
            ? 'text-brand-600'
            : '-translate-x-1 text-ink-300 opacity-0 group-hover/navitem:translate-x-0 group-hover/navitem:text-brand-600 group-hover/navitem:opacity-100'}`;

    return (
        <nav aria-label="Product categories" className="rounded-2xl border border-ink-100 bg-white p-3 shadow-card">
            <p className="px-3 pb-2.5 pt-1 text-xs font-semibold uppercase tracking-[0.04em] text-ink-500">{title}</p>
            <Link href="/products" className={itemCls(false)}>
                <span className={tileCls(false)}><FontAwesomeIcon icon={faBorderAll} style={{ fontSize: 14 }} aria-hidden /></span>
                <span className="min-w-0 flex-1">{allLabel}</span>
                <FontAwesomeIcon icon={faChevronRight} style={{ fontSize: 12 }} className={chevronCls(false)} aria-hidden />
            </Link>
            <ul className="mt-1 space-y-1">
                {siblings.map((s) => (
                    <li key={s.slug}>
                        <Link href={`/product/${s.slug}`} aria-current={s.slug === current ? 'page' : undefined}
                           className={itemCls(s.slug === current)}>
                            <span className={tileCls(s.slug === current)}><CategoryIcon name={s.icon} size={15} /></span>
                            <span className="min-w-0 flex-1">{s.name}</span>
                            <FontAwesomeIcon icon={faChevronRight} style={{ fontSize: 12 }} className={chevronCls(s.slug === current)} aria-hidden />
                        </Link>
                    </li>
                ))}
            </ul>
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
                                <Reveal variant="media" className="mb-10 rounded-2xl shadow-card">
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
                                <div className="mt-12 rounded-2xl border border-ink-100 bg-ink-50/60 p-7 sm:p-9">
                                    <p className="text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{c.range_eyebrow}</p>
                                    <h2 className="mt-2 t-h3 text-ink-900">{fill(c.range_title, vars)}</h2>
                                    {c.range_lead && <p className="mt-3 max-w-2xl text-[0.9375rem] leading-relaxed text-ink-600">{c.range_lead}</p>}
                                    {groups.length > 0 && (
                                        <ul className="mt-6 grid gap-2.5 sm:grid-cols-2 lg:grid-cols-3">
                                            {groups.map((g) => (
                                                <li key={g.name}>
                                                    <Link href={`${category.catalogue_url}#group-${g.name.replace(/\W+/g, '-').toLowerCase()}`}
                                                          className="card-hover group flex items-center justify-between gap-3 rounded-xl border border-ink-100 bg-white px-4 py-3 text-sm font-semibold text-ink-800">
                                                        <span className="flex items-center gap-2"><FontAwesomeIcon style={{ fontSize: 15 }} icon={faListCheck} className="shrink-0 text-brand-600" aria-hidden />{g.name}</span>
                                                        <span className="shrink-0 rounded-lg bg-ink-50 px-2 py-0.5 text-xs font-semibold text-ink-500 group-hover:bg-brand-50 group-hover:text-brand-700">{g.count}</span>
                                                    </Link>
                                                </li>
                                            ))}
                                        </ul>
                                    )}
                                    <ButtonLink href={category.catalogue_url} className="mt-7">
                                        {fill(c.catalogue_label, vars)} <FontAwesomeIcon style={{ fontSize: 16 }} icon={faArrowRight} className="btn-arrow" aria-hidden />
                                    </ButtonLink>
                                </div>
                            </Reveal>

                            {c.show_cta && (
                                <Reveal>
                                    <div className="card-hover mt-10 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 p-8 text-white">
                                        <h2 className="t-h3">{fill(c.cta_title, vars)}</h2>
                                        <p className="mt-2 max-w-xl text-[0.9375rem] leading-relaxed text-brand-100">{c.cta_body}</p>
                                        <ButtonLink href="/contact" variant="light" className="mt-5">{c.cta_button} <FontAwesomeIcon style={{ fontSize: 15 }} icon={faArrowRight} className="btn-arrow" aria-hidden /></ButtonLink>
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
