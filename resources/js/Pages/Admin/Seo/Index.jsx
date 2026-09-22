import { Link } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Per-page SEO overrides for static/list pages. Structured data is
 * auto-derived from content — never hand-edited JSON-LD.
 */
export default function SeoIndex({ pages }) {
    return (
        <AdminLayout title="Page SEO">
            <p className="mb-5 max-w-2xl text-sm text-ink-500">
                Overrides for static and listing pages. Blank fields fall back to sensible
                controller defaults. Product, article, market and category pages carry their
                own SEO fields in their respective editors. Structured data (schema.org) is
                generated automatically from content — it stays valid by construction.
            </p>
            <div className="overflow-x-auto rounded-xl border border-ink-200 bg-white">
                <table className="w-full text-left text-sm">
                    <thead>
                        <tr className="border-b border-ink-100 bg-ink-50/60 text-xs font-bold uppercase tracking-wider text-ink-500">
                            <th scope="col" className="px-4 py-3">Page</th>
                            <th scope="col" className="px-4 py-3">Meta title</th>
                            <th scope="col" className="px-4 py-3">Meta description</th>
                            <th scope="col" className="px-4 py-3">Status</th>
                            <th scope="col" className="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-ink-100">
                        {pages.map((p) => (
                            <tr key={p.id} className="hover:bg-ink-50/50">
                                <td className="px-4 py-3 font-semibold text-ink-900">{p.label}</td>
                                <td className="max-w-[220px] truncate px-4 py-3 text-ink-600">{p.meta_title || '—'}</td>
                                <td className="max-w-[260px] truncate px-4 py-3 text-ink-600">{p.meta_description || '—'}</td>
                                <td className="px-4 py-3">
                                    {p.customized
                                        ? <span className="rounded-full bg-brand-50 px-2 py-0.5 text-xs font-bold text-brand-800">Custom</span>
                                        : <span className="rounded-full bg-ink-100 px-2 py-0.5 text-xs font-bold text-ink-500">Default</span>}
                                </td>
                                <td className="px-4 py-3 text-right">
                                    <Link href={`/admin/seo-pages/${p.id}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit SEO</Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
