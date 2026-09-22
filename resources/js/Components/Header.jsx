import { Link, usePage } from '@inertiajs/react';
import { ChevronDown, Mail, Menu, Phone, X } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import Logo from './Logo';

const links = [
    { name: 'Home', href: '/' },
    { name: 'About Us', href: '/about' },
    { name: 'Products', href: '/products', dropdown: true },
    { name: 'Manufacturing', href: '/manufacturing' },
    { name: 'Quality', href: '/quality-certifications' },
    { name: 'Global Presence', href: '/global-presence' },
    { name: 'Team', href: '/team' },
    { name: 'Inside Nymak', href: '/inside-nymak' },
    { name: 'Blog', href: '/blog' },
];

function track(contact) {
    if (typeof window !== 'undefined' && window.nymakTrack) {
        window.nymakTrack('contact_click', { method: contact });
    }
}

export default function Header() {
    const { site, nav } = usePage().props;
    const currentUrl = usePage().url;
    const [mobileOpen, setMobileOpen] = useState(false);
    const [dropOpen, setDropOpen] = useState(false);
    const [scrolled, setScrolled] = useState(false);
    const dropRef = useRef(null);

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
        const onKey = (e) => { if (e.key === 'Escape') { setMobileOpen(false); setDropOpen(false); } };
        const onClick = (e) => { if (dropRef.current && !dropRef.current.contains(e.target)) setDropOpen(false); };
        document.addEventListener('keydown', onKey);
        document.addEventListener('mousedown', onClick);
        return () => { document.removeEventListener('keydown', onKey); document.removeEventListener('mousedown', onClick); };
    }, []);

    const isActive = (href) => href === '/' ? currentUrl === '/' : currentUrl.startsWith(href);

    return (
        <header className="site-header sticky top-0 z-50" data-scrolled={scrolled}>
            {/* Utility bar */}
            <div className="bg-ink-950 text-ink-100">
                <div className="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-1.5 text-xs sm:px-6">
                    <p className="hidden font-medium tracking-wide text-ink-300 md:block">
                        WHO-GMP Certified · Star Export House · Exporting to 24+ Countries
                    </p>
                    <div className="flex items-center gap-4">
                        <a href={`tel:${site.phone_href}`} onClick={() => track('phone')}
                           className="inline-flex items-center gap-1.5 hover:text-white">
                            <Phone size={12} aria-hidden /> <span className="hidden sm:inline">{site.phone}</span><span className="sm:hidden">Call</span>
                        </a>
                        <a href={`mailto:${site.email}`} onClick={() => track('email')}
                           className="inline-flex items-center gap-1.5 hover:text-white">
                            <Mail size={12} aria-hidden /> {site.email}
                        </a>
                    </div>
                </div>
            </div>

            {/* Main nav */}
            <div className="border-b border-ink-100 bg-white/95 backdrop-blur">
                <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
                    <Link href="/" aria-label="Nymak Pharma — home"><Logo /></Link>

                    <nav aria-label="Primary" className="hidden items-center gap-1 lg:flex">
                        {links.map((link) =>
                            link.dropdown ? (
                                <div key={link.name} className="group relative" ref={dropRef}>
                                    <div className="inline-flex items-center">
                                        {/* "Products" navigates; the chevron toggles the menu */}
                                        <Link href={link.href}
                                              className={`rounded-l-lg py-2 pl-3 pr-1 text-sm font-semibold transition-colors ${
                                                  isActive(link.href) ? 'text-brand-700' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-950'
                                              }`}>
                                            {link.name}
                                        </Link>
                                        <button
                                            type="button"
                                            aria-expanded={dropOpen}
                                            aria-haspopup="true"
                                            aria-label="Product categories"
                                            onClick={() => setDropOpen((v) => !v)}
                                            className={`rounded-r-lg py-2 pl-0.5 pr-2 transition-colors ${
                                                isActive(link.href) ? 'text-brand-700' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-950'
                                            }`}
                                        >
                                            <ChevronDown size={14} aria-hidden className={`transition-transform ${dropOpen ? 'rotate-180' : ''}`} />
                                        </button>
                                    </div>
                                    {/* CSS hover/focus keeps it working pre-hydration; dropOpen covers touch taps */}
                                    <div className={`absolute left-0 top-full w-72 rounded-xl border border-ink-100 bg-white p-2 shadow-card ${
                                        dropOpen ? 'block' : 'hidden group-hover:block group-focus-within:block'
                                    }`}>
                                        <Link href="/products"
                                              className="block rounded-lg px-3 py-2 text-sm font-bold text-ink-900 hover:bg-brand-50">
                                            All Products
                                        </Link>
                                        <div className="my-1 h-px bg-ink-100" />
                                        {(nav?.categories || []).map((c) => (
                                            <Link key={c.href} href={c.href}
                                                  className="block rounded-lg px-3 py-2 text-sm font-medium text-ink-700 hover:bg-brand-50 hover:text-brand-800">
                                                {c.name}
                                            </Link>
                                        ))}
                                    </div>
                                </div>
                            ) : (
                                <Link key={link.name} href={link.href}
                                      className={`rounded-lg px-3 py-2 text-sm font-semibold transition-colors ${
                                          isActive(link.href) ? 'text-brand-700' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-950'
                                      }`}>
                                    {link.name}
                                </Link>
                            )
                        )}
                        <Link href="/contact"
                              className="ml-2 rounded-lg bg-brand-700 px-4 py-2 text-sm font-bold text-white transition-colors hover:bg-brand-800">
                            Contact Us
                        </Link>
                    </nav>

                    <button type="button" className="rounded-lg p-2 text-ink-800 hover:bg-ink-50 lg:hidden"
                            aria-expanded={mobileOpen} aria-controls="mobile-nav"
                            aria-label={mobileOpen ? 'Close menu' : 'Open menu'}
                            onClick={() => setMobileOpen((v) => !v)}>
                        {mobileOpen ? <X size={22} /> : <Menu size={22} />}
                    </button>
                </div>

                {/* Mobile nav */}
                {mobileOpen && (
                    <nav id="mobile-nav" aria-label="Mobile" className="border-t border-ink-100 bg-white lg:hidden">
                        <div className="mx-auto max-w-7xl space-y-1 px-4 py-4 sm:px-6">
                            {links.map((link) =>
                                link.dropdown ? (
                                    <div key={link.name}>
                                        <Link href={link.href}
                                              className={`block rounded-lg px-3 py-2.5 text-sm font-bold ${isActive(link.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-800'}`}>
                                            {link.name}
                                        </Link>
                                        <div className="ml-3 border-l-2 border-ink-100 pl-2">
                                            {(nav?.categories || []).map((c) => (
                                                <Link key={c.href} href={c.href}
                                                      className="block rounded-lg px-3 py-2 text-sm font-medium text-ink-600 hover:bg-ink-50">
                                                    {c.name}
                                                </Link>
                                            ))}
                                        </div>
                                    </div>
                                ) : (
                                    <Link key={link.name} href={link.href}
                                          className={`block rounded-lg px-3 py-2.5 text-sm font-semibold ${isActive(link.href) ? 'bg-brand-50 text-brand-800' : 'text-ink-800'}`}>
                                        {link.name}
                                    </Link>
                                )
                            )}
                            <Link href="/contact"
                                  className="mt-2 block rounded-lg bg-brand-700 px-3 py-2.5 text-center text-sm font-bold text-white">
                                Contact Us
                            </Link>
                        </div>
                    </nav>
                )}
            </div>
        </header>
    );
}
