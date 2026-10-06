import Link from '../i18n/LocaleLink';
import { useT } from '../i18n/useT';
import { ArrowRight, Droplets, Pill, ScanSearch, ShieldPlus, Syringe } from 'lucide-react';

export const categoryIcons = {
    droplets: Droplets,
    pill: Pill,
    syringe: Syringe,
    'scan-search': ScanSearch,
    'shield-plus': ShieldPlus,
};

export function CategoryIcon({ name, size = 22, className = '' }) {
    const Icon = categoryIcons[name] || Pill;
    return <Icon size={size} className={className} aria-hidden />;
}

export function CategoryCard({ category, href, label = 'Explore category', index }) {
    const { t } = useT();
    return (
        <Link href={href}
              className="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-[transform,border-color,box-shadow] duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover">
            {/* Accent hairline draws across the top on hover */}
            <span className="absolute inset-x-0 top-0 h-0.5 origin-left scale-x-0 bg-gradient-to-r from-brand-600 to-brand-400 transition-transform duration-300 ease-out group-hover:scale-x-100" aria-hidden />
            <span className="flex items-start justify-between gap-3">
                <span className="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-brand-100 bg-brand-50 text-brand-700 transition-colors duration-200 group-hover:border-brand-700 group-hover:bg-brand-700 group-hover:text-white">
                    <CategoryIcon name={category.icon} size={20} />
                </span>
                {index != null && (
                    <span className="t-caption font-bold tabular-nums text-ink-300">{String(index + 1).padStart(2, '0')}</span>
                )}
            </span>
            <h3 className="mt-4 t-h4 text-pretty text-ink-900 transition-colors group-hover:text-brand-800">{category.name}</h3>
            {category.products_count > 0 && (
                <p className="t-caption mt-1 tabular-nums text-ink-400">{t('{n} products', { n: category.products_count })}</p>
            )}
            {category.intro && <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{category.intro}</p>}
            <span className="mt-4 inline-flex items-center gap-1 text-[15px] font-semibold text-brand-700">
                {t(label)}
                <ArrowRight size={15} aria-hidden className="transition-transform duration-200 group-hover:translate-x-0.5" />
            </span>
        </Link>
    );
}

export function ProductCard({ product, url }) {
    const { t } = useT();
    const inner = (
        <>
            <span className="block aspect-[4/3] overflow-hidden bg-ink-50">
                {product.image ? (
                    <img src={`/${product.image}`} alt={`${product.name} — Nymak Pharma`}
                         width="800" height="600" loading="lazy"
                         className="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.03]" />
                ) : (
                    <span className="flex h-full items-center justify-center text-ink-300"><Pill size={32} /></span>
                )}
            </span>
            <span className="block p-4">
                <span className="block text-[15px] font-semibold text-ink-900 group-hover:text-brand-800">{product.name}</span>
                {product.description && (
                    <span className="mt-1 line-clamp-2 block text-xs leading-relaxed text-ink-500">{product.description}</span>
                )}
                <span className="t-caption mt-2 inline-flex items-center gap-1 font-semibold text-brand-700">
                    {t('View product')} <ArrowRight size={13} className="btn-arrow" aria-hidden />
                </span>
            </span>
        </>
    );

    const cls = 'group block overflow-hidden rounded-2xl border border-ink-100 bg-white shadow-card transition-[transform,border-color,box-shadow] duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover';
    return url ? <Link href={url} className={cls}>{inner}</Link> : <div className={cls}>{inner}</div>;
}

export function PostCard({ post }) {
    const { locale } = useT();
    const date = post.published_at
        ? new Date(post.published_at).toLocaleDateString({ en: 'en-GB', fr: 'fr-FR', es: 'es-ES' }[locale] || 'en-GB', { day: 'numeric', month: 'long', year: 'numeric' })
        : null;
    return (
        <Link href={`/blog/${post.slug}`}
              className="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-[transform,border-color,box-shadow] duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover">
            <span className="absolute inset-x-0 top-0 h-0.5 origin-left scale-x-0 bg-gradient-to-r from-brand-600 to-brand-400 transition-transform duration-300 ease-out group-hover:scale-x-100" aria-hidden />
            <p className="t-eyebrow text-brand-700">{post.category}</p>
            <h3 className="mt-2 t-h4 text-pretty text-ink-900 transition-colors group-hover:text-brand-800">{post.title}</h3>
            {post.excerpt && <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{post.excerpt}</p>}
            {date && <p className="mt-4 t-caption text-ink-400">{date}</p>}
        </Link>
    );
}
