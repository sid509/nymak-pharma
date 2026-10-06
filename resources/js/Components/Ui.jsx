import Link from '../i18n/LocaleLink';
import { useT } from '../i18n/useT';
import { useState } from 'react';
import { CountUp } from './Motion';
import { ChevronRight, Globe2 } from 'lucide-react';

export function WhatsAppIcon({ size = 24, className = '' }) {
    return (
        <svg viewBox="0 0 24 24" width={size} height={size} fill="currentColor" className={className} aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    );
}

export function CountryFlag({ iso, className = 'h-5 w-7', iconClass = 'h-5 w-5' }) {
    const [failed, setFailed] = useState(false);
    if (!iso || failed) return <Globe2 className={`${iconClass} shrink-0 text-gold-400`} aria-hidden />;
    return (
        <img src={`/images/flags/${String(iso).toLowerCase()}.svg`} alt="" loading="lazy"
             onError={() => setFailed(true)}
             className={`${className} shrink-0 rounded-[3px] object-cover ring-1 ring-black/10`} />
    );
}

export function Container({ children, className = '' }) {
    return <div className={`mx-auto max-w-7xl px-4 sm:px-6 ${className}`}>{children}</div>;
}

export function Eyebrow({ children, center = false, dark = false }) {
    const rule = <span className="h-px w-6 bg-gold-400" aria-hidden />;
    return (
        <p className={`t-eyebrow mb-3 flex items-center gap-2.5 ${dark ? 'text-brand-300' : 'text-gold-700'} ${center ? 'justify-center' : ''}`}>
            {rule}{children}{center && rule}
        </p>
    );
}

export function SectionHeading({ eyebrow, title, lead, align = 'center', className = '', titleClass = 'text-gradient' }) {
    return (
        <div className={`${align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl'} ${className}`}>
            {eyebrow && <Eyebrow center={align === 'center'}>{eyebrow}</Eyebrow>}
            <h2 className={`t-h2 text-balance ${titleClass}`}>{title}</h2>
            {lead && <p className="t-lead mt-4 text-pretty text-ink-600">{lead}</p>}
        </div>
    );
}

export function ButtonLink({ href, children, variant = 'primary', className = '', external = false, ...rest }) {
    const base = 't-button inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
    const styles = {
        primary: 'btn-cta bg-brand-600 text-white hover:bg-brand-700',
        outline: 'btn-cta border border-ink-200 bg-white text-ink-800 hover:border-brand-500 hover:bg-brand-50/60 hover:text-brand-800',
        outlineLight: 'btn-cta border border-white/40 bg-transparent text-white hover:border-white hover:bg-white/10',
        light: 'btn-cta bg-white text-ink-900 hover:bg-brand-50',
        ghost: 'text-brand-700 hover:bg-brand-50',
    };
    const cls = `${base} ${styles[variant]} ${className}`;

    if (external) {
        return <a href={href} className={cls} {...rest}>{children}</a>;
    }
    return <Link href={href} className={cls} {...rest}>{children}</Link>;
}

export function Breadcrumbs({ items, className = 'mb-6', dark = false, center = false }) {
    const { t } = useT();
    return (
        <nav aria-label={t('Breadcrumb')} className={className}>
            <ol className={`flex flex-wrap items-center gap-1.5 text-[13px] ${center ? 'justify-center' : ''} ${dark ? 'text-white/50' : 'text-ink-500'}`}>
                {items.map(([name, href], i) => (
                    <li key={i} className="flex items-center gap-1.5">
                        {i > 0 && <ChevronRight size={13} aria-hidden className={dark ? 'text-white/25' : 'text-ink-300'} />}
                        {href ? (
                            <Link href={href} className={`underline-offset-4 transition-colors hover:underline ${dark ? 'hover:text-brand-300' : 'hover:text-brand-700'}`}>{t(name)}</Link>
                        ) : (
                            <span aria-current="page" className={`font-semibold ${dark ? 'text-white' : 'text-ink-800'}`}>{t(name)}</span>
                        )}
                    </li>
                ))}
            </ol>
        </nav>
    );
}

export function Stat({ value, label, className = '', tone = 'dark', icon: Icon }) {
    const light = tone === 'light';
    return (
        <div className={`group flex items-center gap-4 ${className}`}>
            {Icon && (
                <span className={`inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border transition-colors duration-200 ${
                    light
                        ? 'border-brand-100 bg-brand-50 text-brand-600 group-hover:border-brand-600 group-hover:bg-brand-600 group-hover:text-white'
                        : 'border-white/15 bg-white/10 text-brand-300'
                }`}>
                    <Icon size={19} aria-hidden />
                </span>
            )}
            <div>
                <p className={`t-figure tabular-nums transition-colors duration-200 ${light ? 'text-ink-950 group-hover:text-brand-800' : 'text-white'}`}>
                    <CountUp value={value} />
                </p>
                <p className={`t-caption mt-1.5 uppercase tracking-[0.04em] ${light ? 'text-gold-700' : 'text-brand-200'}`}>{label}</p>
            </div>
        </div>
    );
}

export function PageHero({ eyebrow, title, lead, breadcrumbs, tone = 'light', align = 'center', children }) {
    const dark = tone === 'dark';
    const center = align === 'center';
    return (
        <section className={dark
            ? 'relative overflow-hidden border-b border-ink-800 bg-gradient-to-br from-gold-800 via-ink-950 to-ink-950'
            : 'border-b border-ink-100 bg-gradient-to-b from-gold-50 via-brand-50/40 to-white'}>
            {dark && (
                <>
                    <div className="absolute -right-24 -top-24 h-80 w-80 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute -right-6 top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute -bottom-28 -left-16 h-64 w-64 rounded-full border border-white/10" aria-hidden />
                    <div className="absolute inset-0 bg-[radial-gradient(45%_60%_at_75%_35%,rgba(79,214,88,0.14),transparent)]" aria-hidden />
                </>
            )}
            <Container className="relative py-9 sm:py-12">
                <div className="enter">
                    {breadcrumbs && <Breadcrumbs items={breadcrumbs} dark={dark} />}
                    <div className={center ? 'mx-auto max-w-3xl text-center' : ''}>
                    {eyebrow && <Eyebrow dark={dark} center={center}>{eyebrow}</Eyebrow>}
                    <h1 className={`t-page max-w-3xl text-balance ${center ? 'mx-auto' : ''} ${dark ? 'text-white' : 'text-ink-950'}`}>{title}</h1>
                    {lead && <p className={`t-lead mt-5 max-w-2xl text-pretty ${center ? 'mx-auto' : ''} ${dark ? 'text-white/70' : 'text-ink-600'}`}>{lead}</p>}
                    {children}
                    </div>
                </div>
            </Container>
        </section>
    );
}
