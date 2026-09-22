import { Link, usePage } from '@inertiajs/react';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

const fmt = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });

export default function UsersIndex({ users }) {
    const { auth } = usePage().props;

    return (
        <AdminLayout title="Admin users">
            <div className="mb-5 flex justify-end">
                <Link href="/admin/users/create"
                      className="rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-bold text-white hover:bg-brand-800">
                    New admin user
                </Link>
            </div>
            <div className="overflow-x-auto rounded-xl border border-ink-200 bg-white">
                <table className="w-full text-left text-sm">
                    <thead>
                        <tr className="border-b border-ink-100 bg-ink-50/60 text-xs font-bold uppercase tracking-wider text-ink-500">
                            <th scope="col" className="px-4 py-3">Name</th>
                            <th scope="col" className="px-4 py-3">Email</th>
                            <th scope="col" className="px-4 py-3">Added</th>
                            <th scope="col" className="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-ink-100">
                        {users.map((u) => (
                            <tr key={u.id} className="hover:bg-ink-50/50">
                                <td className="px-4 py-3 font-semibold text-ink-900">
                                    {u.name}{u.id === auth?.user?.id && <span className="ml-2 rounded-full bg-brand-50 px-2 py-0.5 text-[10px] font-bold text-brand-800">you</span>}
                                </td>
                                <td className="px-4 py-3 text-ink-600">{u.email}</td>
                                <td className="px-4 py-3 text-ink-600">{fmt(u.created_at)}</td>
                                <td className="px-4 py-3 text-right">
                                    <div className="flex justify-end gap-3">
                                        <Link href={`/admin/users/${u.id}/edit`} className="text-xs font-bold text-brand-700 hover:underline">Edit</Link>
                                        {u.id !== auth?.user?.id && <ConfirmDelete href={`/admin/users/${u.id}`} name={u.name} />}
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
