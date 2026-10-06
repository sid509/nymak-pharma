import { usePage } from '@inertiajs/react';
import { Check, Globe2 } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { CountryFlag } from '../Components/Ui';

const LANGS = [
    { code: 'en', label: 'English', iso: 'gb' },
    { code: 'fr', label: 'Français', iso: 'fr' },
    { code: 'es', label: 'Español', iso: 'es' },
];

/**
 * Locale switcher — plain anchors to the current page's alternate URLs
 * (shared `locales` prop), so a switch reloads shared props + document lang
 * in one pass. `dark` suits the ink-950 topbar; default suits white surfaces.
 */
export default function LanguageSwitcher({ dark = true, className = '' }) {
    const { locales = {}, locale = 'en' } = usePage().props;
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        if (!open) return;
        const close = (e) => { if (!ref.current?.contains(e.target)) setOpen(false); };
        const esc = (e) => { if (e.key === 'Escape') setOpen(false); };
        document.addEventListener('mousedown', close);
        document.addEventListener('keydown', esc);
        return () => { document.removeEventListener('mousedown', close); document.removeEventListener('keydown', esc); };
    }, [open]);

    const btn = dark
        ? 'text-white/70 hover:text-white'
        : 'text-ink-600 hover:bg-ink-50 hover:text-ink-950';

    return (
        <div ref={ref} className={`relative ${className}`}>
            <button type="button" aria-expanded={open} aria-haspopup="true"
                    aria-label="Choose language"
                    onClick={() => setOpen((v) => !v)}
                    className={`inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 transition-colors ${btn}`}>
                <Globe2 size={12} aria-hidden />
                <span className="uppercase tracking-wide">{locale}</span>
            </button>
            {open && (
                <div className="absolute right-0 top-full z-50 mt-1.5 w-40 overflow-hidden rounded-xl border border-ink-100 bg-white p-1 shadow-card">
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
