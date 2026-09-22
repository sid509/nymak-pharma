import { Link, usePage } from '@inertiajs/react';
import { Mail, MapPin, Phone } from 'lucide-react';
import Logo from './Logo';
import SocialIcon from './SocialIcons';

function track(contact) {
    if (typeof window !== 'undefined' && window.nymakTrack) {
        window.nymakTrack('contact_click', { method: contact, location: 'footer' });
    }
}

export default function Footer() {
    const { site, nav } = usePage().props;
    const year = new Date().getFullYear();

    return (
        <footer className="bg-ink-950 text-ink-200">
            <div className="mx-auto max-w-7xl px-4 py-14 sm:px-6">
                <div className="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                    {/* Brand + NAP */}
                    <div>
                        <Link href="/" aria-label="Nymak Pharma — home"><Logo light /></Link>
                        <p className="mt-4 text-sm leading-relaxed text-ink-300">
                            25+ years of efficacy-driven lifecare. WHO-GMP certified pharmaceutical
                            manufacturer and exporter serving 24+ countries.
                        </p>
                        <div className="mt-4 flex gap-2">
                            {Object.entries(site.socials || {}).map(([key, href]) => (
                                <a key={key} href={href} target="_blank" rel="noopener noreferrer"
                                   aria-label={`Nymak Pharma on ${key}`}
                                   className="rounded-lg bg-ink-800 p-2 text-ink-200 transition-colors hover:bg-brand-700 hover:text-white">
                                    <SocialIcon name={key} size={16} />
                                </a>
                            ))}
                        </div>
                    </div>

                    {/* Quick links */}
                    <nav aria-label="Footer">
                        <h2 className="text-xs font-bold uppercase tracking-widest text-brand-300">Company</h2>
                        <ul className="mt-4 space-y-2 text-sm">
                            {[
                                ['About Us', '/about'],
                                ['Manufacturing', '/manufacturing'],
                                ['Quality & Certifications', '/quality-certifications'],
                                ['Global Presence', '/global-presence'],
                                ['Blog & Resources', '/blog'],
                                ['FAQs', '/faqs'],
                                ['Contact Us', '/contact'],
                            ].map(([name, href]) => (
                                <li key={href}><Link href={href} className="hover:text-white">{name}</Link></li>
                            ))}
                        </ul>
                    </nav>

                    {/* Products */}
                    <nav aria-label="Product categories">
                        <h2 className="text-xs font-bold uppercase tracking-widest text-brand-300">Products</h2>
                        <ul className="mt-4 space-y-2 text-sm">
                            <li><Link href="/products" className="hover:text-white">All Products</Link></li>
                            {(nav?.categories || []).map((c) => (
                                <li key={c.href}><Link href={c.href} className="hover:text-white">{c.name}</Link></li>
                            ))}
                        </ul>
                    </nav>

                    {/* Contact / NAP — consistent name+address+phone (requirement #17) */}
                    <div>
                        <h2 className="text-xs font-bold uppercase tracking-widest text-brand-300">Get in Touch</h2>
                        <address className="mt-4 space-y-3 text-sm not-italic">
                            <p className="flex gap-2">
                                <MapPin size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden />
                                <span>{site.address.street}, {site.address.city}, {site.address.region}, {site.address.country}</span>
                            </p>
                            <p>
                                <a href={`tel:${site.phone_href}`} onClick={() => track('phone')}
                                   className="flex gap-2 hover:text-white">
                                    <Phone size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden /> {site.phone}
                                </a>
                            </p>
                            <p>
                                <a href={`mailto:${site.email}`} onClick={() => track('email')}
                                   className="flex gap-2 hover:text-white">
                                    <Mail size={16} className="mt-0.5 shrink-0 text-brand-400" aria-hidden /> {site.email}
                                </a>
                            </p>
                        </address>
                    </div>
                </div>

                <div className="mt-12 flex flex-col items-center justify-between gap-4 border-t border-ink-800 pt-6 text-xs text-ink-400 sm:flex-row">
                    <p>© {year} {site.legal_name}. All rights reserved.</p>
                    <p className="flex gap-4">
                        <Link href="/privacy-policy" className="hover:text-white">Privacy Policy</Link>
                        <Link href="/terms" className="hover:text-white">Terms of Use</Link>
                        <a href="/nymak-pharma-brochure.pdf" target="_blank" rel="noopener noreferrer"
                           onClick={() => track('brochure_download')} className="hover:text-white">Brochure</a>
                        <a href="/sitemap.xml" className="hover:text-white">Sitemap</a>
                    </p>
                </div>
            </div>
        </footer>
    );
}
