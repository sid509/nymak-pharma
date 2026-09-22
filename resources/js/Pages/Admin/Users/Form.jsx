import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function UserForm({ user = null }) {
    const isEdit = !!user;
    const form = useForm({
        name: user?.name || '',
        email: user?.email || '',
        password: '',
        password_confirmation: '',
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        isEdit ? form.put(`/admin/users/${user.id}`) : form.post('/admin/users');
    };

    return (
        <AdminLayout title={isEdit ? `Edit: ${user.name}` : 'New admin user'}>
            <form onSubmit={submit} className="max-w-lg space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                <Field field={{ name: 'name', label: 'Name', required: true }} value={form.data.name} error={form.errors.name} onChange={set} />
                <Field field={{ name: 'email', label: 'Email', type: 'email', required: true }} value={form.data.email} error={form.errors.email} onChange={set} />
                <Field field={{ name: 'password', label: 'Password', type: 'password', required: !isEdit,
                    help: isEdit ? 'Leave blank to keep the current password.' : 'Min 8 characters.' }}
                    value={form.data.password} error={form.errors.password} onChange={set} />
                <Field field={{ name: 'password_confirmation', label: 'Confirm password', type: 'password' }}
                    value={form.data.password_confirmation} error={form.errors.password_confirmation} onChange={set} />

                <div className="flex items-center gap-3 border-t border-ink-100 pt-5">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create user'}
                    </button>
                    <Link href="/admin/users" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
