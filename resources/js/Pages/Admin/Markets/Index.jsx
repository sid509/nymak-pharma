import { Link } from '@inertiajs/react';
import DataTable from '../../../Components/Admin/DataTable';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function MarketsIndex({ markets, filters }) {
    return (
        <AdminLayout title="Markets">
            <DataTable
                title="markets"
                basePath="/admin/markets"
                createHref="/admin/markets/create"
                createLabel="New market"
                columns={[
                    { key: 'name', label: 'Market' },
                    { key: 'iso_code', label: 'ISO' },
                    { key: 'region', label: 'Region' },
                    { key: 'products_count', label: 'Products' },
                    { key: 'show_in_portfolio', label: 'Portfolio', type: 'bool' },
                ]}
                rows={markets}
                filters={filters}
                searchPlaceholder="Search markets…"
                renderRow={(m) => (
                    <tr key={m.id} className="hover:bg-ink-50/50">
                        <td className="px-4 py-3 font-semibold text-ink-900">{m.name}</td>
                        <td className="px-4 py-3 text-sm text-ink-600">{m.iso_code || '—'}</td>
                        <td className="px-4 py-3 text-sm text-ink-600">{m.region || '—'}</td>
                        <td className="px-4 py-3 text-sm text-ink-600">{m.products_count}</td>
                        <td className="px-4 py-3">
                            {m.show_in_portfolio
                                ? <span className="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-700">Listed</span>
                                : <span className="text-xs text-ink-300">—</span>}
                        </td>
                        <td className="px-4 py-3 text-right">
                            <div className="flex justify-end gap-3">
                                <Link href={`/admin/markets/${m.slug}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                <ConfirmDelete href={`/admin/markets/${m.slug}`} name={m.name} />
                            </div>
                        </td>
                    </tr>
                )} />
        </AdminLayout>
    );
}
