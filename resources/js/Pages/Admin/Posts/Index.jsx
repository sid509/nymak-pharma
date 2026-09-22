import { Link, router } from '@inertiajs/react';
import DataTable from '../../../Components/Admin/DataTable';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

const fmt = (d) => d ? new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : null;

export default function PostsIndex({ posts, filters }) {
    const setStatus = (status) => router.get('/admin/posts', { q: filters.q, status: status || undefined }, { preserveState: true, replace: true });

    return (
        <AdminLayout title="Articles">
            <DataTable
                title="articles"
                basePath="/admin/posts"
                createHref="/admin/posts/create"
                createLabel="New article"
                columns={[
                    { key: 'title', label: 'Title' },
                    { key: 'category', label: 'Category' },
                    { key: 'status', label: 'Status' },
                    { key: 'published_at', label: 'Published' },
                ]}
                rows={posts}
                filters={filters}
                searchPlaceholder="Search title or category…"
                statusFilter={
                    <select value={filters.status || ''} onChange={(e) => setStatus(e.target.value)}
                            className="rounded-lg border border-ink-200 bg-white px-3 py-2 text-sm font-semibold text-ink-700">
                        <option value="">All</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                }
                renderRow={(p) => (
                    <tr key={p.id} className="hover:bg-ink-50/50">
                        <td className="max-w-[260px] px-4 py-3">
                            <p className="truncate font-semibold text-ink-900">{p.title}</p>
                        </td>
                        <td className="px-4 py-3 text-sm text-ink-600">{p.category || '—'}</td>
                        <td className="px-4 py-3">
                            {p.published_at
                                ? <span className="rounded-full bg-brand-50 px-2 py-0.5 text-xs font-bold text-brand-800">Published</span>
                                : <span className="rounded-full bg-ink-100 px-2 py-0.5 text-xs font-bold text-ink-500">Draft</span>}
                        </td>
                        <td className="px-4 py-3 text-sm text-ink-600">{fmt(p.published_at) || '—'}</td>
                        <td className="px-4 py-3 text-right">
                            <div className="flex justify-end gap-3">
                                {p.published_at && <Link href={`/blog/${p.slug}`} target="_blank" className="text-xs font-bold text-ink-400 hover:underline">View</Link>}
                                <Link href={`/admin/posts/${p.slug}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                <ConfirmDelete href={`/admin/posts/${p.slug}`} name={p.title} />
                            </div>
                        </td>
                    </tr>
                )} />
        </AdminLayout>
    );
}
