import { usePage } from '@inertiajs/react';
import { Check, ChevronDown } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { CountryFlag } from '../Components/Ui';
import { useT } from './useT';

const LANGS = [
    { code: 'en', label: 'English', iso: 'gb' },
    { code: 'fr', label: 'Français', iso: 'fr' },
    { code: 'es', label: 'Español', iso: 'es' },
];

/**
 * Locale switcher — plain anchors to the current page's alternate URLs
 * (shared `locales` prop), so a switch reloads shared props + document lang
 * in one pass. `dark` suits the ink-950 topbar; `menu` renders the mobile
 * drawer's inline flag row instead of a dropdown.
 */
export default function LanguageSwitcher({ dark = true, menu = false, className = '' }) {
    const { locales = {}, locale = 'en' } = usePage().props;
    const { t } = useT();
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        if (!open || menu) return;
        const close = (e) => { if (!ref.current?.contains(e.target)) setOpen(false); };
        const esc = (e) => { if (e.key === 'Escape') setOpen(false); };
        document.addEventListener('mousedown', close);
        document.addEventListener('keydown', esc);
        return () => { document.removeEventListener('mousedown', close); document.removeEventListener('keydown', esc); };
    }, [open, menu]);

    const current = LANGS.find((l) => l.code === locale) ?? LANGS[0];

    if (menu) {
        return (
            <div className={className}>
                <p className="t-eyebrow px-3 pb-1 text-ink-400">{t('Choose language')}</p>
                <div className="flex gap-2 px-3">
                    {LANGS.map((l) => (
                        <a key={l.code} href={locales[l.code] || '/'}
                           aria-label={l.label} aria-current={l.code === locale ? 'true' : undefined}
                           className={`flex flex-1 items-center justify-center gap-2 rounded-lg border px-3 py-2.5 text-xs font-bold transition-colors ${
                               l.code === locale
                                   ? 'border-brand-300 bg-brand-50 text-brand-800'
                                   : 'border-ink-200 text-ink-600 hover:border-brand-200 hover:bg-ink-50 hover:text-ink-900'
                           }`}>
                            <CountryFlag iso={l.iso} className="h-3.5 w-5 rounded-[2px] ring-1 ring-ink-100" />
                            <span className="uppercase">{l.code}</span>
                        </a>
                    ))}
                </div>
            </div>
        );
    }

    const btn = dark
        ? 'text-white/70 hover:text-white hover:bg-white/10'
        : 't-nav text-ink-600 ring-1 ring-ink-200 hover:bg-ink-50 hover:text-ink-950 hover:ring-ink-300';

    return (
        <div ref={ref} className={`relative ${className}`}>
            <button type="button" aria-expanded={open} aria-haspopup="true"
                    aria-label={t('Choose language')} data-locale-switcher
                    onClick={() => setOpen((v) => !v)}
                    className={`inline-flex items-center gap-1.5 rounded-full px-2 py-1 transition-colors ${btn}`}>
                <CountryFlag iso={current.iso} className="h-3.5 w-5 rounded-[2px] ring-1 ring-white/20" />
                <span className="uppercase tracking-wide">{current.code}</span>
                <ChevronDown size={11} aria-hidden className={`transition-transform ${open ? 'rotate-180' : ''}`} />
            </button>
            {open && (
                <div className="absolute right-0 top-full z-50 mt-1.5 w-44 overflow-hidden rounded-xl border border-ink-100 bg-white p-1 shadow-card">
                    {LANGS.map((l) => (
                        <a key={l.code} href={locales[l.code] || '/'}
                               className={`flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold transition-colors ${
                                   l.code === locale ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-950'
                               }`}>
                            <CountryFlag iso={l.iso} className="h-3.5 w-5 rounded-[2px] ring-1 ring-ink-100" />
                            <span className="flex-1">{l.label}</span>
                            {l.code === locale && <Check size={12} aria-hidden className="text-brand-700" />}
                        </a>
                    ))}
                </div>
            )}
        </div>
    );
}
