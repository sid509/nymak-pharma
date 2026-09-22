import { Link, router, usePage } from '@inertiajs/react';
import {
    BadgeCheck, CircleHelp, FileText, Globe2, Inbox, LayoutDashboard, LogOut,
    Menu, Newspaper, Package, Quote, Search, Settings, Tag, Users, X,
} from 'lucide-react';
import { useEffect, useState } from 'react';

const NAV = [
    { group: 'Overview', items: [
        { name: 'Dashboard', href: '/admin/dashboard', icon: LayoutDashboard },
        { name: 'Enquiries', href: '/admin/enquiries', icon: Inbox, badge: 'unread' },
    ]},
    { group: 'Catalogue', items: [
        { name: 'Products', href: '/admin/products', icon: Package },
        { name: 'Categories', href: '/admin/categories', icon: Tag },
        { name: 'Markets', href: '/admin/markets', icon: Globe2 },
    ]},
    { group: 'Content', items: [
        { name: 'Articles', href: '/admin/posts', icon: Newspaper },
        { name: 'FAQs', href: '/admin/faqs', icon: CircleHelp },
        { name: 'Testimonials', href: '/admin/testimonials', icon: Quote },
        { name: 'Certifications', href: '/admin/certifications', icon: BadgeCheck },
        { name: 'Team', href: '/admin/team-members', icon: Users },
        { name: 'Client logos', href: '/admin/clients', icon: BadgeCheck },
        { name: 'Page content', href: '/admin/pages', icon: FileText },
    ]},
    { group: 'System', items: [
        { name: 'SEO pages', href: '/admin/seo-pages', icon: Search },
        { name: 'Site settings', href: '/admin/settings', icon: Settings },
        { name: 'Admin users', href: '/admin/users', icon: Users },
    ]},
];

export default function AdminLayout({ title, children }) {
    const { auth, admin, flash } = usePage().props;
    const url = usePage().url;
    const [navOpen, setNavOpen] = useState(false);

    useEffect(() => setNavOpen(false), [url]);
    useEffect(() => { if (title) document.title = `${title} | Admin`; }, [title]);

    const isActive = (href) => url === href || url.startsWith(`${href}/`);

    const sidebar = (
        <div className="flex h-full flex-col">
            <div className="flex items-center justify-between px-5 py-4">
                <Link href="/admin/dashboard" className="text-base font-extrabold tracking-tight text-white">
                    Nymak <span className="text-brand-400">Admin</span>
                </Link>
                <button type="button" onClick={() => setNavOpen(false)} className="p-1 text-ink-300 hover:text-white lg:hidden" aria-label="Close menu">
                    <X size={20} />
                </button>
            </div>
            <nav aria-label="Admin" className="flex-1 space-y-5 overflow-y-auto px-3 pb-6">
                {NAV.map((section) => (
                    <div key={section.group}>
                        <p className="px-2 pb-1.5 text-[10px] font-bold uppercase tracking-widest text-ink-500">{section.group}</p>
                        <ul className="space-y-0.5">
                            {section.items.map((item) => (
                                <li key={item.href}>
                                    <Link href={item.href}
                                          className={`flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-semibold transition-colors ${
                                              isActive(item.href) ? 'bg-white/10 text-white' : 'text-ink-300 hover:bg-white/5 hover:text-white'
                                          }`}>
                                        <item.icon size={16} aria-hidden className="shrink-0" />
                                        <span className="flex-1">{item.name}</span>
                                        {item.badge === 'unread' && admin?.unreadEnquiries > 0 && (
                                            <span className="rounded-full bg-brand-500 px-1.5 py-0.5 text-[10px] font-bold text-white">
                                                {admin.unreadEnquiries}
                                            </span>
                                        )}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                ))}
            </nav>
            <div className="border-t border-white/10 p-3">
                <Link href="/admin/profile" className="block rounded-lg px-2.5 py-1.5 text-sm font-semibold text-ink-300 hover:bg-white/5 hover:text-white">
                    {auth?.user?.name}
                </Link>
                <Link href="/" className="block rounded-lg px-2.5 py-1.5 text-xs text-ink-500 hover:text-ink-300">
                    View public site ↗
                </Link>
            </div>
        </div>
    );

    return (
        <div className="min-h-screen bg-ink-50">
            {/* Mobile top bar */}
            <div className="sticky top-0 z-40 flex items-center justify-between border-b border-ink-200 bg-white px-4 py-3 lg:hidden">
                <button type="button" onClick={() => setNavOpen(true)} className="rounded-lg p-2 hover:bg-ink-100" aria-label="Open menu">
                    <Menu size={20} />
                </button>
                <span className="text-sm font-extrabold text-ink-900">{title || 'Admin'}</span>
                <button type="button" onClick={() => router.post('/admin/logout')} className="rounded-lg p-2 text-ink-500 hover:bg-ink-100" aria-label="Log out">
                    <LogOut size={18} />
                </button>
            </div>

            {/* Sidebar — fixed on desktop, drawer on mobile */}
            <aside className={`fixed inset-y-0 left-0 z-50 w-64 bg-ink-950 transition-transform lg:translate-x-0 ${navOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                {sidebar}
            </aside>
            {navOpen && <div className="fixed inset-0 z-40 bg-ink-950/50 lg:hidden" onClick={() => setNavOpen(false)} aria-hidden />}

            <div className="lg:pl-64">
                <header className="sticky top-0 z-30 hidden items-center justify-between border-b border-ink-200 bg-white px-8 py-3.5 lg:flex">
                    <h1 className="text-lg font-extrabold text-ink-900">{title}</h1>
                    <div className="flex items-center gap-4">
                        <Link href="/admin/profile" className="text-sm font-semibold text-ink-600 hover:text-ink-900">{auth?.user?.name}</Link>
                        <button type="button" onClick={() => router.post('/admin/logout')}
                                className="inline-flex items-center gap-1.5 rounded-lg border border-ink-200 px-3 py-1.5 text-xs font-bold text-ink-600 hover:bg-ink-50">
                            <LogOut size={13} aria-hidden /> Log out
                        </button>
                    </div>
                </header>

                <main className="mx-auto max-w-6xl px-4 py-8 sm:px-8">
                    {flash?.success && (
                        <div role="status" className="mb-6 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm font-semibold text-brand-900">
                            {flash.success}
                        </div>
                    )}
                    {children}
                </main>
            </div>
        </div>
    );
}
