import { usePage } from '@inertiajs/react';
import Link from '../i18n/LocaleLink';
import LanguageSwitcher from '../i18n/LanguageSwitcher';
import { useT } from '../i18n/useT';
import { ArrowRight, ChevronDown, Mail, Menu, Phone, X } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { CategoryIcon } from './Cards';
import Logo from './Logo';

const links = [
    { name: 'Home', href: '/' },
    { name: 'About Us', href: '/about' },
    { name: 'Products', href: '/products', dropdown: true },
    { name: 'Manufacturing', href: '/manufacturing' },
    { name: 'Quality', href: '/quality-certifications' },
    { name: 'Global Presence', href: '/global-presence' },
];

const companyLinks = [
    { name: 'Our Team', href: '/team' },
    { name: 'Inside Nymak', href: '/inside-nymak' },
    { name: 'Blog', href: '/blog' },
];

function track(contact) {
    if (typeof window !== 'undefined' && window.nymakTrack) {
        window.nymakTrack('contact_click', { method: contact });
    }
}

export default function Header() {
    const { site = {}, nav } = usePage().props;
    const { t } = useT();
    const currentUrl = usePage().url.replace(/^\/(fr|es)(?=\/|$)/, '') || '/';
    const [mobileOpen, setMobileOpen] = useState(false);
    const [openMenu, setOpenMenu] = useState(null); // 'products' | 'company' | null
    const [scrolled, setScrolled] = useState(false);
    const productsRef = useRef(null);
    const companyRef = useRef(null);

    // Header gains a floor shadow once the page scrolls (continuity cue).
    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > 8);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    // Close menus on navigation / escape / outside click.
    useEffect(() => setMobileOpen(false), [currentUrl]);
    useEffect(() => {
        const onKey = (e) => { if (e.key === 'Escape') { setMobileOpen(false); setOpenMenu(null); } };
        const onClick = (e) => {
            const inside = [productsRef, companyRef].some((r) => r.current?.contains(e.target));
            if (!inside) setOpenMenu(null);
        };
        document.addEventListener('keydown', onKey);
        document.addEventListener('mousedown', onClick);
        return () => { document.removeEventListener('keydown', onKey); document.removeEventListener('mousedown', onClick); };
    }, []);

    const isActive = (href) => href === '/' ? currentUrl === '/' : currentUrl.startsWith(href);
    const companyActive = companyLinks.some((l) => isActive(l.href));

    const pill = (active) =>
        `rounded-full px-3.5 py-2 transition-colors ${active ? 'bg-brand-50 text-brand-800' : 'text-ink-600 hover:bg-ink-50 hover:text-ink-950'}`;

    return (
        <header className="site-header sticky top-0 z-50" data-scrolled={scrolled}>
            {/* Utility bar — folds away once the page scrolls */}
            <div className="topbar bg-ink-950 text-white/70">
                <div>
                    <div className="mx-auto flex w-full max-w-[90rem] items-center justify-between gap-4 px-4 py-1.5 text-xs sm:px-6 lg:px-10">
                        <p className="hidden font-medium tracking-wide md:block">
                            <span className="text-brand-300">{t('WHO-GMP Certified')}</span>
                            <span className="mx-2 text-white/25">·</span>{t('Star Export House')}
                            <span className="mx-2 text-white/25">·</span>{t('Exporting to 24+ Countries')}
                        </p>
                        <div className="flex items-center gap-4">
                            <LanguageSwitcher />
                            <a href={`tel:${site.phone_href}`} onClick={() => track('phone')}
                               className="inline-flex items-center gap-1.5 transition-colors hover:text-white">
                                <Phone size={12} aria-hidden /> <span className="hidden sm:inline">{site.phone}</span><span className="sm:hidden">{t('Call')}</span>
                            </a>
                            <a href={`mailto:${site.email}`} onClick={() => track('email')}
                               className="inline-flex items-center gap-1.5 transition-colors hover:text-white">
                                <Mail size={12} aria-hidden /> {site.email}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {/* Main nav */}
            <div className="border-b border-ink-100 bg-white/95 backdrop-blur">
                <div className="mx-auto flex max-w-[90rem] items-center justify-between px-4 py-2 sm:px-6 lg:px-10">
                    <Link href="/" aria-label="Nymak Pharma — home"><Logo /></Link>

                    <nav aria-label="Primary" className="hidden items-center gap-0.5 xl:flex">
                        {links.map((link) =>
                            link.dropdown ? (
                                <div key={link.name} className="group relative" ref={productsRef}>
                                    <div className={`inline-flex items-center rounded-full transition-colors ${
                                        isActive(link.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-600 hover:bg-ink-50 hover:text-ink-950'
                                    }`}>
                                        {/* "Products" navigates; the chevron toggles the menu */}
                                        <Link href={link.href}
                                              className="t-nav rounded-l-full py-2 pl-3.5 pr-1">
                                            {t(link.name)}
                                        </Link>
                                        <button
                                            type="button"
                                            aria-expanded={openMenu === 'products'}
                                            aria-haspopup="true"
                                            aria-label="Product categories"
                                            onClick={() => setOpenMenu((v) => (v === 'products' ? null : 'products'))}
                                            className="rounded-r-full py-2 pl-0.5 pr-2.5"
                                        >
                                            <ChevronDown size={14} aria-hidden className={`transition-transform duration-200 ${openMenu === 'products' ? 'rotate-180' : ''}`} />
                                        </button>
                                    </div>
                                    {/* CSS hover/focus keeps it working pre-hydration; openMenu covers touch taps */}
                                    <div className={`nav-drop absolute left-1/2 top-full w-[34rem] max-w-[92vw] -translate-x-1/2 rounded-2xl border border-ink-100 bg-white p-3 shadow-card ${
                                        openMenu === 'products' ? 'block' : 'hidden group-hover:block group-focus-within:block'
                                    }`}>
                                        <p className="t-eyebrow px-3 pb-2 pt-1 text-ink-400">{t('Product portfolio')}</p>
                                        <div className="grid grid-cols-2 gap-1">
                                            {(nav?.categories || []).map((c) => (
                                                <Link key={c.href} href={c.href}
                                                      className="group/item flex items-center gap-3 rounded-xl px-3 py-2.5 transition-colors hover:bg-brand-50">
                                                    <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-ink-100 bg-white text-ink-400 transition-colors group-hover/item:border-brand-200 group-hover/item:text-brand-700">
                                                        <CategoryIcon name={c.icon} size={17} />
                                                    </span>
                                                    <span className="min-w-0">
                                                        <span className="block t-nav leading-snug text-ink-800 transition-colors group-hover/item:text-brand-800">{c.name}</span>
                                                        {c.count > 0 && <span className="t-caption tabular-nums text-ink-400">{t('{n} products', { n: c.count })}</span>}
                                                    </span>
                                                </Link>
                                            ))}
                                        </div>
                                        <div className="mt-1 border-t border-ink-100 px-3 pb-1 pt-2.5">
                                            <Link href="/products"
                                                  className="t-nav inline-flex items-center gap-1.5 font-semibold text-brand-700 transition-colors hover:text-brand-800">
                                                All product categories <ArrowRight size={14} className="btn-arrow" aria-hidden />
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ) : (
                                <Link key={link.name} href={link.href}
                                      className={`t-nav ${pill(isActive(link.href))}`}>
                                    {t(link.name)}
                                </Link>
                            )
                        )}

                        {/* Company — secondary pages grouped to keep the bar compact */}
                        <div className="group relative" ref={companyRef}>
                            <button
                                type="button"
                                aria-expanded={openMenu === 'company'}
                                aria-haspopup="true"
                                aria-label="Company pages"
                                onClick={() => setOpenMenu((v) => (v === 'company' ? null : 'company'))}
                                className={`t-nav inline-flex items-center gap-1 ${pill(companyActive)}`}
                            >
                                {t('Company')}
                                <ChevronDown size={14} aria-hidden className={`transition-transform duration-200 ${openMenu === 'company' ? 'rotate-180' : ''}`} />
                            </button>
                            <div className={`nav-drop absolute right-0 top-full w-52 rounded-2xl border border-ink-100 bg-white p-2 shadow-card ${
                                openMenu === 'company' ? 'block' : 'hidden group-hover:block group-focus-within:block'
                            }`}>
                                {companyLinks.map((c) => (
                                    <Link key={c.href} href={c.href}
                                          className={`block rounded-xl px-3.5 py-2.5 t-nav transition-colors ${
                                              isActive(c.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-950'
                                          }`}>
                                        {c.name}
                                    </Link>
                                ))}
                            </div>
                        </div>

                        <Link href="/contact"
                              className="t-button btn-cta ml-3 rounded-full bg-brand-600 px-5 py-2.5 text-white transition-colors hover:bg-brand-700">
                            {t('Contact Us')}
                        </Link>
                    </nav>

                    <button type="button" className="rounded-lg p-2 text-ink-800 hover:bg-ink-50 xl:hidden"
                            aria-expanded={mobileOpen} aria-controls="mobile-nav"
                            aria-label={mobileOpen ? 'Close menu' : 'Open menu'}
                            onClick={() => setMobileOpen((v) => !v)}>
                        {mobileOpen ? <X size={22} /> : <Menu size={22} />}
                    </button>
                </div>

                {/* Mobile nav */}
                {mobileOpen && (
                    <nav id="mobile-nav" aria-label="Mobile" className="nav-mobile border-t border-ink-100 bg-white xl:hidden">
                        <div className="mx-auto max-w-[90rem] space-y-1 px-4 py-4 sm:px-6 lg:px-10">
                            {links.map((link) =>
                                link.dropdown ? (
                                    <div key={link.name}>
                                        <Link href={link.href}
                                              className={`t-nav block rounded-lg px-3 py-2.5 font-semibold ${isActive(link.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-800'}`}>
                                            {t(link.name)}
                                        </Link>
                                        <div className="ml-3 border-l-2 border-ink-100 pl-2">
                                            {(nav?.categories || []).map((c) => (
                                                <Link key={c.href} href={c.href}
                                                      className="t-nav flex items-center gap-2.5 rounded-lg px-3 py-2 text-ink-600 hover:bg-ink-50">
                                                    <CategoryIcon name={c.icon} size={15} className="shrink-0 text-brand-600" />
                                                    <span className="min-w-0 flex-1 truncate">{c.name}</span>
                                                    {c.count > 0 && <span className="t-caption tabular-nums text-ink-400">{c.count}</span>}
                                                </Link>
                                            ))}
                                        </div>
                                    </div>
                                ) : (
                                    <Link key={link.name} href={link.href}
                                          className={`t-nav block rounded-lg px-3 py-2.5 ${isActive(link.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-800'}`}>
                                        {link.name}
                                    </Link>
                                )
                            )}

                            <div className="pt-2">
                                <p className="t-eyebrow px-3 pb-1 text-ink-400">{t('Company')}</p>
                                <div className="ml-3 border-l-2 border-ink-100 pl-2">
                                    {companyLinks.map((c) => (
                                        <Link key={c.href} href={c.href}
                                              className={`t-nav block rounded-lg px-3 py-2.5 ${isActive(c.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-600 hover:bg-ink-50'}`}>
                                            {t(c.name)}
                                        </Link>
                                    ))}
                                </div>
                            </div>

                            <Link href="/contact"
                                  className="t-button mt-2 block rounded-full bg-brand-600 px-3 py-2.5 text-center text-white">
                                {t('Contact Us')}
                            </Link>
                        </div>
                    </nav>
                )}
            </div>
        </header>
    );
}
