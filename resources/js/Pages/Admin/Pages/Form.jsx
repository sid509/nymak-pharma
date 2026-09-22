import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Page content editor — renders the page's slot schema. Image slots upload
 * files (stored path overrides the default); text slots save verbatim;
 * clearing a text field restores its default.
 */
export default function PageForm({ page, fields, values, stored }) {
    const initial = Object.fromEntries(fields.map((f) => [
        f.name,
        f.type === 'image' ? null
            : f.type === 'json' ? JSON.stringify(values[f.name] ?? [], null, 2)
            : values[f.name] ?? '',
    ]));
    const form = useForm({ ...initial, _method: 'PUT' });

    const submit = (e) => {
        e.preventDefault();
        form.post(`/admin/pages/${page.key}`, { forceFormData: true });
    };

    return (
        <AdminLayout title={`Content: ${page.label}`}>
            <form onSubmit={submit} className="max-w-3xl space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                <p className="text-xs text-ink-400">
                    Changes publish immediately to the live page. Clear a text field to restore its default.
                </p>
                {fields.map((f) => (
                    <Field key={f.name}
                           field={{ ...f,
                               type: f.type === 'json' ? 'textarea' : f.type,
                               rows: f.type === 'json' ? 10 : f.rows,
                               preview: f.type === 'image' ? values[f.name] : null,
                               help: f.help || (stored[f.name] == null ? 'Default value shown.' : 'Custom value saved.') }}
                           value={form.data[f.name]}
                           error={form.errors[f.name]}
                           onChange={(k, v) => form.setData(k, v)} />
                ))}
                <div className="flex items-center gap-3 border-t border-ink-100 pt-5">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Save page content'}
                    </button>
                    <Link href="/admin/pages" className="text-sm font-bold text-ink-500 hover:text-ink-800">Back to pages</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
