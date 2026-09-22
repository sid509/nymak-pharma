import { Link } from '@inertiajs/react';
import { CountUp } from './Motion';
import { ChevronRight } from 'lucide-react';

export function Container({ children, className = '' }) {
    return <div className={`mx-auto max-w-7xl px-4 sm:px-6 ${className}`}>{children}</div>;
}

export function Eyebrow({ children }) {
    return (
        <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-700">{children}</p>
    );
}

export function SectionHeading({ eyebrow, title, lead, align = 'left', className = '' }) {
    return (
        <div className={`${align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl'} ${className}`}>
            {eyebrow && <Eyebrow>{eyebrow}</Eyebrow>}
            <h2 className="text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">{title}</h2>
            {lead && <p className="mt-4 text-lg leading-relaxed text-ink-600">{lead}</p>}
        </div>
    );
}

export function ButtonLink({ href, children, variant = 'primary', className = '', external = false, ...rest }) {
    const base = 'inline-flex items-center justify-center gap-2 rounded-lg px-5 py-3 text-sm font-bold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
    const styles = {
        primary: 'btn-cta bg-brand-700 text-white hover:bg-brand-800',
        outline: 'btn-cta border border-ink-200 bg-white text-ink-800 hover:border-brand-400 hover:text-brand-800',
        light: 'btn-cta bg-white text-ink-900 hover:bg-brand-50',
        ghost: 'text-brand-700 hover:bg-brand-50',
    };
    const cls = `${base} ${styles[variant]} ${className}`;

    if (external) {
        return <a href={href} className={cls} {...rest}>{children}</a>;
    }
    return <Link href={href} className={cls} {...rest}>{children}</Link>;
}

export function Breadcrumbs({ items }) {
    return (
        <nav aria-label="Breadcrumb" className="mb-6">
            <ol className="flex flex-wrap items-center gap-1.5 text-sm text-ink-500">
                {items.map(([name, href], i) => (
                    <li key={i} className="flex items-center gap-1.5">
                        {i > 0 && <ChevronRight size={14} aria-hidden className="text-ink-300" />}
                        {href ? (
                            <Link href={href} className="hover:text-brand-700">{name}</Link>
                        ) : (
                            <span aria-current="page" className="font-semibold text-ink-800">{name}</span>
                        )}
                    </li>
                ))}
            </ol>
        </nav>
    );
}

export function Stat({ value, label }) {
    return (
        <div>
            <p className="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                <CountUp value={value} />
            </p>
            <p className="mt-1 text-sm font-semibold uppercase tracking-wider text-brand-200">{label}</p>
        </div>
    );
}

export function PageHero({ eyebrow, title, lead, breadcrumbs }) {
    return (
        <section className="border-b border-ink-100 bg-gradient-to-b from-brand-50/60 to-white">
            <Container className="py-14 sm:py-20">
                {breadcrumbs && <Breadcrumbs items={breadcrumbs} />}
                {eyebrow && <Eyebrow>{eyebrow}</Eyebrow>}
                <h1 className="max-w-3xl text-4xl font-extrabold tracking-tight text-ink-950 sm:text-5xl">{title}</h1>
                {lead && <p className="mt-5 max-w-2xl text-lg leading-relaxed text-ink-600">{lead}</p>}
            </Container>
        </section>
    );
}
