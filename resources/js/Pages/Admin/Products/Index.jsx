import { Link, router } from '@inertiajs/react';
import DataTable from '../../../Components/Admin/DataTable';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function ProductsIndex({ products, categories, filters }) {
    const setCategory = (category) => router.get('/admin/products', { q: filters.q, category: category || undefined }, { preserveState: true, replace: true });

    return (
        <AdminLayout title="Products">
            <DataTable
                title="products"
                basePath="/admin/products"
                createHref="/admin/products/create"
                createLabel="New product"
                columns={[
                    { key: 'img', label: '', class: 'w-14' },
                    { key: 'name', label: 'Name' },
                    { key: 'category_name', label: 'Category' },
                    { key: 'strength', label: 'Strength' },
                    { key: 'pack_size', label: 'Pack' },
                    { key: 'detail', label: 'Page' },
                ]}
                rows={products}
                filters={filters}
                searchPlaceholder="Search name, strength, group…"
                statusFilter={
                    <select value={filters.category || ''} onChange={(e) => setCategory(e.target.value)}
                            className="rounded-lg border border-ink-200 bg-white px-3 py-2 text-sm font-semibold text-ink-700">
                        <option value="">All categories</option>
                        {categories.map((c) => <option key={c.id} value={c.slug}>{c.name}</option>)}
                    </select>
                }
                renderRow={(p) => (
                    <tr key={p.id} className="hover:bg-ink-50/50">
                        <td className="px-4 py-2">
                            {p.image
                                ? <img src={`/${p.image}`} alt="" className="h-10 w-10 rounded-lg border border-ink-100 bg-white object-contain" />
                                : <span className="flex h-10 w-10 items-center justify-center rounded-lg bg-ink-50 text-[9px] font-bold uppercase text-ink-300">none</span>}
                        </td>
                        <td className="px-4 py-3">
                            <p className="font-semibold text-ink-900">{p.name}</p>
                            {p.therapeutic_group && <p className="text-xs text-ink-400">{p.therapeutic_group}</p>}
                        </td>
                        <td className="px-4 py-3 text-sm text-ink-600">{p.category?.name}</td>
                        <td className="px-4 py-3 text-sm text-ink-600">{p.strength || '—'}</td>
                        <td className="px-4 py-3 text-sm text-ink-600">{p.pack_size || '—'}</td>
                        <td className="px-4 py-3">
                            {p.has_detail_page
                                ? <Link href={`/product/${p.category.slug}/${p.slug}`} target="_blank" className="text-xs font-bold text-brand-700 hover:underline">Live ↗</Link>
                                : <span className="text-xs text-ink-300">—</span>}
                        </td>
                        <td className="px-4 py-3 text-right">
                            <div className="flex justify-end gap-3">
                                <Link href={`/admin/products/${p.slug}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                <ConfirmDelete href={`/admin/products/${p.slug}`} name={p.name} />
                            </div>
                        </td>
                    </tr>
                )} />
        </AdminLayout>
    );
}
