import { Link } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Editable content pages — each public page's copy and images are slots
 * declared in PageContent::SCHEMA; stored rows override defaults.
 */
export default function PagesIndex({ pages }) {
    return (
        <AdminLayout title="Page content">
            <p className="mb-5 max-w-2xl text-sm text-ink-500">
                Edit the copy and images on each public page. Blank text fields fall back to
                the built-in default; images keep the current file until replaced.
            </p>
            <div className="overflow-x-auto rounded-xl border border-ink-200 bg-white">
                <table className="w-full text-left text-sm">
                    <thead>
                        <tr className="border-b border-ink-100 bg-ink-50/60 text-xs font-bold uppercase tracking-wider text-ink-500">
                            <th scope="col" className="px-4 py-3">Page</th>
                            <th scope="col" className="px-4 py-3">Editable fields</th>
                            <th scope="col" className="px-4 py-3">Customized</th>
                            <th scope="col" className="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-ink-100">
                        {pages.map((p) => (
                            <tr key={p.key} className="hover:bg-ink-50/50">
                                <td className="px-4 py-3 font-semibold text-ink-900">{p.label}</td>
                                <td className="px-4 py-3 text-ink-600">{p.fields}</td>
                                <td className="px-4 py-3">
                                    {p.customized > 0
                                        ? <span className="rounded-full bg-brand-50 px-2 py-0.5 text-xs font-bold text-brand-800">{p.customized} overridden</span>
                                        : <span className="rounded-full bg-ink-100 px-2 py-0.5 text-xs font-bold text-ink-500">Defaults</span>}
                                </td>
                                <td className="px-4 py-3 text-right">
                                    <Link href={`/admin/pages/${p.key}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit content</Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
