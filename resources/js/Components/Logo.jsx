import { usePage } from '@inertiajs/react';

export default function Logo({ className = '', light = false }) {
    const { site } = usePage().props;

    // Admin-uploaded logo (Site settings) replaces the built-in SVG wordmark.
    if (site?.logo_uploaded) {
        return <img src={`/${site.logo}`} alt={site.name || 'Nymak Pharma'} className={`h-10 w-auto ${className}`} />;
    }

    return (
        <span className={`inline-flex items-center gap-2.5 ${className}`}>
            {/* Wordmark mark: stylised N monogram in brand square */}
            <svg width="38" height="38" viewBox="0 0 40 40" aria-hidden="true" className="shrink-0">
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
                <span className={`block text-xl font-extrabold tracking-tight ${light ? 'text-white' : 'text-ink-900'}`}>
                    NYMAK
                </span>
                <span className={`block text-[10px] font-semibold uppercase tracking-[0.22em] ${light ? 'text-brand-200' : 'text-brand-700'}`}>
                    Pharma
                </span>
            </span>
        </span>
    );
}
