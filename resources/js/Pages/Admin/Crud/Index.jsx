import { Link } from '@inertiajs/react';
import DataTable from '../../../Components/Admin/DataTable';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Generic list page for simple content entities — columns and routes are
 * driven by the controller's module config.
 */
export default function CrudIndex({ module, columns, rows, filters }) {
    const base = `/admin/${module.route}`;

    return (
        <AdminLayout title={module.title}>
            <DataTable
                title={module.title}
                columns={columns}
                rows={rows}
                filters={filters}
                basePath={base}
                createHref={`${base}/create`}
                createLabel={`New ${module.singular || module.title}`}
                renderRow={(row, cell) => (
                    <tr key={row.id} className="hover:bg-ink-50/50">
                        {columns.map((c) => <td key={c.key} className="px-4 py-3 align-top">{cell(row, c)}</td>)}
                        <td className="px-4 py-3 text-right align-top">
                            <div className="flex justify-end gap-3">
                                <Link href={`${base}/${row.id}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                <ConfirmDelete href={`${base}/${row.id}`} name={row.name || row.question || row.title || module.singular || 'record'} />
                            </div>
                        </td>
                    </tr>
                )} />
        </AdminLayout>
    );
}
