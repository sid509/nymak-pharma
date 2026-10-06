import { useForm, usePage } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../Components/Admin/Field';
import AdminLayout from '../../Layouts/AdminLayout';

export default function Profile() {
    const { auth } = usePage().props;
    const form = useForm({ current_password: '', password: '', password_confirmation: '' });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        form.put('/admin/profile/password', { onSuccess: () => form.reset() });
    };

    return (
        <AdminLayout title="Your profile">
            <div className="max-w-lg space-y-6">
                <section className="rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-bold uppercase tracking-wider text-ink-500">Account</h2>
                    <dl className="mt-4 space-y-2 text-sm">
                        <div className="flex gap-4"><dt className="w-20 font-bold text-ink-500">Name</dt><dd className="text-ink-900">{auth?.user?.name}</dd></div>
                        <div className="flex gap-4"><dt className="w-20 font-bold text-ink-500">Email</dt><dd className="text-ink-900">{auth?.user?.email}</dd></div>
                    </dl>
                </section>

                <form onSubmit={submit} className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-bold uppercase tracking-wider text-ink-500">Change password</h2>
                    <Field field={{ name: 'current_password', label: 'Current password', type: 'password', required: true }}
                           value={form.data.current_password} error={form.errors.current_password} onChange={set} />
                    <Field field={{ name: 'password', label: 'New password', type: 'password', required: true, help: 'Min 8 characters.' }}
                           value={form.data.password} error={form.errors.password} onChange={set} />
                    <Field field={{ name: 'password_confirmation', label: 'Confirm new password', type: 'password' }}
                           value={form.data.password_confirmation} error={form.errors.password_confirmation} onChange={set} />
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Update password'}
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
