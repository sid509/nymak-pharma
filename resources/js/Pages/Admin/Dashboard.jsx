import { Link } from '@inertiajs/react';
import { ArrowRight, Globe2, Inbox, Newspaper, Package } from 'lucide-react';
import AdminLayout from '../../Layouts/AdminLayout';

const fmt = (d) => new Date(d).toLocaleString('en-GB', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });

export default function Dashboard({ stats, recentEnquiries }) {
    const cards = [
        { label: 'Unread enquiries', value: stats.enquiries_unread, href: '/admin/enquiries?status=unread', icon: Inbox, accent: stats.enquiries_unread > 0 },
        { label: 'Total enquiries', value: stats.enquiries_total, href: '/admin/enquiries', icon: Inbox },
        { label: 'Products', value: stats.products, href: '/admin/products', icon: Package },
        { label: 'With detail pages', value: stats.products_with_pages, href: '/admin/products', icon: Package },
        { label: 'Detail pages missing image', value: stats.products_no_image, href: '/admin/products', icon: Package, accent: stats.products_no_image > 0 },
        { label: 'Markets', value: stats.markets, href: '/admin/markets', icon: Globe2 },
        { label: 'Published articles', value: stats.posts_published, href: '/admin/posts', icon: Newspaper },
        { label: 'Draft articles', value: stats.posts_draft, href: '/admin/posts?status=draft', icon: Newspaper, accent: stats.posts_draft > 0 },
    ];

    return (
        <AdminLayout title="Dashboard">
            <div className="grid grid-cols-2 gap-3 sm:grid-cols-4">
                {cards.map((c) => (
                    <Link key={c.label} href={c.href}
                          className={`rounded-xl border p-4 transition-colors hover:border-brand-300 ${c.accent ? 'border-brand-300 bg-brand-50/50' : 'border-ink-200 bg-white'}`}>
                        <div className="flex items-center justify-between">
                            <c.icon size={16} className={c.accent ? 'text-brand-700' : 'text-ink-400'} aria-hidden />
                            <span className="text-2xl font-extrabold tabular-nums text-ink-900">{c.value}</span>
                        </div>
                        <p className="mt-1 text-xs font-semibold text-ink-500">{c.label}</p>
                    </Link>
                ))}
            </div>

            <div className="mt-8 rounded-xl border border-ink-200 bg-white">
                <div className="flex items-center justify-between border-b border-ink-100 px-5 py-3.5">
                    <h2 className="text-sm font-extrabold text-ink-900">Latest enquiries</h2>
                    <Link href="/admin/enquiries" className="inline-flex items-center gap-1 text-xs font-bold text-brand-700 hover:underline">
                        View all <ArrowRight size={12} className="btn-arrow" aria-hidden />
                    </Link>
                </div>
                {recentEnquiries.length === 0 ? (
                    <p className="px-5 py-8 text-center text-sm text-ink-400">No enquiries yet.</p>
                ) : (
                    <ul className="divide-y divide-ink-100">
                        {recentEnquiries.map((e) => (
                            <li key={e.id}>
                                <Link href="/admin/enquiries" className="flex items-center gap-3 px-5 py-3 hover:bg-ink-50/60">
                                    {!e.read_at && <span className="h-2 w-2 shrink-0 rounded-full bg-brand-500" title="Unread" />}
                                    <span className={`min-w-0 flex-1 ${e.read_at ? 'text-ink-600' : 'font-semibold text-ink-900'}`}>
                                        <span className="block truncate text-sm">{e.subject || e.name}</span>
                                        <span className="block truncate text-xs text-ink-400">{e.name}{e.company ? ` · ${e.company}` : ''}{e.country ? ` · ${e.country}` : ''}</span>
                                    </span>
                                    <span className="shrink-0 text-xs text-ink-400">{fmt(e.created_at)}</span>
                                </Link>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </AdminLayout>
    );
}
