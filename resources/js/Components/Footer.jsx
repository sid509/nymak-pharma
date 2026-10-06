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
    const { site = {}, nav } = usePage().props;
    const year = new Date().getFullYear();

    return (
        <footer className="bg-ink-950 text-ink-200">
            <div className="mx-auto max-w-[90rem] px-4 py-14 sm:px-6 lg:px-10">
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
                        <p className="t-eyebrow text-gold-400">Company</p>
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
                                <li key={href}><Link href={href} className="transition-colors hover:text-white">{name}</Link></li>
                            ))}
                        </ul>
                    </nav>

                    {/* Products */}
                    <nav aria-label="Product categories">
                        <p className="t-eyebrow text-gold-400">Products</p>
                        <ul className="mt-4 space-y-2 text-sm">
                            <li><Link href="/products" className="transition-colors hover:text-white">All Products</Link></li>
                            {(nav?.categories || []).map((c) => (
                                <li key={c.href}><Link href={c.href} className="transition-colors hover:text-white">{c.name}</Link></li>
                            ))}
                        </ul>
                    </nav>

                    {/* Contact / NAP — consistent name+address+phone (requirement #17) */}
                    <div>
                        <p className="t-eyebrow text-gold-400">Get in Touch</p>
                        <address className="mt-4 space-y-3 text-sm not-italic">
                            <p className="flex gap-2">
                                <MapPin size={16} className="mt-0.5 shrink-0 text-gold-400" aria-hidden />
                                <span>{site.address.street}, {site.address.city}, {site.address.region}, {site.address.country}</span>
                            </p>
                            <p>
                                <a href={`tel:${site.phone_href}`} onClick={() => track('phone')}
                                   className="flex gap-2 transition-colors hover:text-white">
                                    <Phone size={16} className="mt-0.5 shrink-0 text-gold-400" aria-hidden /> {site.phone}
                                </a>
                            </p>
                            <p>
                                <a href={`mailto:${site.email}`} onClick={() => track('email')}
                                   className="flex gap-2 transition-colors hover:text-white">
                                    <Mail size={16} className="mt-0.5 shrink-0 text-gold-400" aria-hidden /> {site.email}
                                </a>
                            </p>
                        </address>
                    </div>
                </div>

                <div className="mt-12 flex flex-col items-center justify-between gap-4 border-t border-ink-800 pt-6 text-xs text-ink-400 sm:flex-row">
                    <p>© {year} {site.legal_name}. All rights reserved.</p>
                    <p className="flex gap-4">
                        <Link href="/privacy-policy" className="transition-colors hover:text-white">Privacy Policy</Link>
                        <Link href="/terms" className="transition-colors hover:text-white">Terms of Use</Link>
                        <a href={`/${site.brochure}`} target="_blank" rel="noopener noreferrer"
                           onClick={() => track('brochure_download')} className="transition-colors hover:text-white">Brochure</a>
                        <a href="/sitemap.xml" className="transition-colors hover:text-white">Sitemap</a>
                    </p>
                </div>
            </div>
        </footer>
    );
}
