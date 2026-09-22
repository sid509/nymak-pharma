import { Link } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function CategoriesIndex({ categories }) {
    return (
        <AdminLayout title="Categories">
            <p className="mb-5 text-sm text-ink-500">
                Product categories are structural — names and content are editable here; adding/removing
                categories is a developer task since they map to public URLs and navigation.
            </p>
            <div className="overflow-x-auto rounded-xl border border-ink-200 bg-white">
                <table className="w-full text-left text-sm">
                    <thead>
                        <tr className="border-b border-ink-100 bg-ink-50/60 text-xs font-bold uppercase tracking-wider text-ink-500">
                            <th scope="col" className="px-4 py-3">Name</th>
                            <th scope="col" className="px-4 py-3">Slug</th>
                            <th scope="col" className="px-4 py-3">Products</th>
                            <th scope="col" className="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-ink-100">
                        {categories.map((c) => (
                            <tr key={c.id} className="hover:bg-ink-50/50">
                                <td className="px-4 py-3 font-semibold text-ink-900">{c.name}</td>
                                <td className="px-4 py-3 font-mono text-xs text-ink-500">{c.slug}</td>
                                <td className="px-4 py-3 text-ink-600">{c.products_count}</td>
                                <td className="px-4 py-3 text-right">
                                    <Link href={`/admin/categories/${c.slug}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
