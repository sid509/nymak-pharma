import { Link } from '@inertiajs/react';
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

export function CategoryCard({ category, href }) {
    return (
        <Link href={href}
              className="group flex h-full flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-all hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card-hover">
            <span className="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition-colors group-hover:bg-brand-700 group-hover:text-white">
                <CategoryIcon name={category.icon} />
            </span>
            <h3 className="mt-4 text-lg font-bold text-ink-900 group-hover:text-brand-800">{category.name}</h3>
            {category.intro && <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{category.intro}</p>}
            <span className="mt-4 inline-flex items-center gap-1 text-sm font-bold text-brand-700">
                {category.products_count != null ? `${category.products_count} products` : 'View range'}
                <ArrowRight size={15} aria-hidden className="transition-transform group-hover:translate-x-0.5" />
            </span>
        </Link>
    );
}

export function ProductCard({ product, url }) {
    const inner = (
        <>
            <span className="block aspect-[4/3] overflow-hidden bg-ink-50">
                {product.image ? (
                    <img src={`/${product.image}`} alt={`${product.name} — Nymak Pharma`}
                         width="800" height="600" loading="lazy"
                         className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                ) : (
                    <span className="flex h-full items-center justify-center text-ink-300"><Pill size={32} /></span>
                )}
            </span>
            <span className="block p-4">
                <span className="block text-sm font-bold text-ink-900 group-hover:text-brand-800">{product.name}</span>
                {product.description && (
                    <span className="mt-1 line-clamp-2 block text-xs leading-relaxed text-ink-500">{product.description}</span>
                )}
                <span className="mt-2 inline-flex items-center gap-1 text-xs font-bold text-brand-700">
                    View product <ArrowRight size={13} className="btn-arrow" aria-hidden />
                </span>
            </span>
        </>
    );

    const cls = 'group block overflow-hidden rounded-2xl border border-ink-100 bg-white shadow-card transition-all hover:-translate-y-0.5 hover:shadow-card-hover';
    return url ? <Link href={url} className={cls}>{inner}</Link> : <div className={cls}>{inner}</div>;
}

export function PostCard({ post }) {
    const date = post.published_at
        ? new Date(post.published_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })
        : null;
    return (
        <Link href={`/blog/${post.slug}`}
              className="group flex h-full flex-col rounded-2xl border border-ink-100 bg-white p-6 shadow-card transition-all hover:-translate-y-0.5 hover:shadow-card-hover">
            <p className="text-xs font-bold uppercase tracking-wider text-brand-700">{post.category}</p>
            <h3 className="mt-2 text-lg font-bold leading-snug text-ink-900 group-hover:text-brand-800">{post.title}</h3>
            {post.excerpt && <p className="mt-2 flex-1 text-sm leading-relaxed text-ink-600">{post.excerpt}</p>}
            {date && <p className="mt-4 text-xs font-semibold text-ink-400">{date}</p>}
        </Link>
    );
}
