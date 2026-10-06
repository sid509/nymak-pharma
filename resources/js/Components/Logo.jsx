import { usePage } from '@inertiajs/react';

export default function Logo({ className = '', light = false, size = 'md' }) {
    const { site } = usePage().props;
    const sm = size === 'sm';

    // Dark surfaces: the favicon N monogram + light wordmark text — the
    // horizontal logo only works on light backgrounds, and a white chip
    // reads as a pasted overlay.
    if (light) {
        return (
            <span className={`inline-flex items-center gap-2.5 ${className}`}>
                <img src="/images/brand/nymak-symbol.png" alt={site?.name || 'Nymak Pharma'}
                     className={`${sm ? 'h-7' : 'h-9'} w-auto shrink-0`} />
                <span className="leading-none">
                    <span className={`block ${sm ? 'text-base' : 'text-lg'} font-bold tracking-tight text-white`}>
                        Nymak
                    </span>
                    <span className="block whitespace-nowrap text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-200">
                        Pharma Pvt. Ltd.
                    </span>
                </span>
            </span>
        );
    }

    // Admin-uploaded logo (Site settings) replaces the built-in SVG wordmark.
    if (site?.logo_uploaded) {
        const img = <img src={`/${site.logo}`} alt={site.name || 'Nymak Pharma'} className={`${sm ? 'h-8' : 'h-10'} w-auto`} />;
        return <span className={className}>{img}</span>;
    }

    return (
        <span className={`inline-flex items-center gap-2.5 ${className}`}>
            {/* Wordmark mark: stylised N monogram in brand square */}
            <svg width={sm ? 30 : 38} height={sm ? 30 : 38} viewBox="0 0 40 40" aria-hidden="true" className="shrink-0">
                <rect width="40" height="40" rx="9" className="fill-brand-700" />
                <path
                    d="M11 29V11l13.4 18h3.1V11"
                    fill="none"
                    stroke="#fff"
                    strokeWidth="3.2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                />
                <circle cx="30.5" cy="9.5" r="2.2" className="fill-gold-400" />
            </svg>
            <span className="leading-none">
                <span className={`block ${sm ? 'text-base' : 'text-xl'} font-bold tracking-tight ${light ? 'text-white' : 'text-ink-900'}`}>
                    NYMAK
                </span>
                <span className={`block text-[10px] font-semibold uppercase tracking-[0.22em] ${light ? 'text-brand-200' : 'text-brand-700'}`}>
                    Pharma
                </span>
            </span>
        </span>
    );
}
