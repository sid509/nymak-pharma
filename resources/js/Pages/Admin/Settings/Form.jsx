import { useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Site-wide company facts — feeds header/footer NAP, Contact page,
 * Organization schema and llms.txt. Blank fields restore config defaults.
 */
export default function SettingsForm({ fields }) {
    const initial = Object.fromEntries(fields.map((f) => [
        f.name,
        (f.type === 'image' || f.type === 'file') ? null : f.value ?? '',
    ]));
    const form = useForm(initial);

    const submit = (e) => {
        e.preventDefault();
        form.put('/admin/settings', { forceFormData: true });
    };

    return (
        <AdminLayout title="Site settings">
            <form onSubmit={submit} className="max-w-2xl space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                <p className="text-xs text-ink-400">
                    These values appear across the whole site — contact page, footer, structured
                    data and llms.txt. Keep them consistent with official company records.
                </p>
                {fields.map((f) => (
                    <Field key={f.name}
                           field={{ ...f, preview: (f.type === 'image' || f.type === 'file') ? f.value : null }}
                           value={form.data[f.name]}
                           error={form.errors[f.name]}
                           onChange={(k, v) => form.setData(k, v)} />
                ))}
                <div className="flex items-center gap-3 border-t border-ink-100 pt-5">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Save settings'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
