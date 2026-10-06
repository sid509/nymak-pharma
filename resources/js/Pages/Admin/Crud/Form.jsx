import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import TranslationFields from '../../../Components/Admin/TranslationFields';
import AdminLayout from '../../../Layouts/AdminLayout';

/**
 * Generic create/edit form for simple entities — fields come from the
 * controller's module config; Laravel form requests remain authoritative.
 * `translatable` config adds French/Spanish inputs merged into the model's
 * i18n JSON column.
 */
export default function CrudForm({ module, fields, translatable = [], record }) {
    const base = `/admin/${module.route}`;
    const isEdit = !!record;
    const hasFiles = fields.some((f) => f.type === 'image');
    const initial = Object.fromEntries(fields.map((f) => [
        f.name,
        f.type === 'image' ? null : record?.[f.name] ?? (f.type === 'checkbox' ? false : ''),
    ]));
    const form = useForm({ ...initial, i18n: record?.i18n ?? {}, ...(isEdit && hasFiles ? { _method: 'PUT' } : {}) });

    const submit = (e) => {
        e.preventDefault();
        const opts = hasFiles ? { forceFormData: true } : {};
        isEdit ? (hasFiles ? form.post(`${base}/${record.id}`, opts) : form.put(`${base}/${record.id}`))
               : form.post(base, opts);
    };

    return (
        <AdminLayout title={`${isEdit ? 'Edit' : 'New'} ${module.singular || module.title}`}>
            <form onSubmit={submit} className="max-w-2xl space-y-6">
                <div className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    {fields.map((f) => (
                        <Field key={f.name} field={{ ...f, preview: f.type === 'image' ? record?.[f.name] : null }}
                               value={form.data[f.name]}
                               error={form.errors[f.name]}
                               onChange={(k, v) => form.setData(k, v)} />
                    ))}
                </div>

                {translatable.length > 0 && <TranslationFields fields={translatable} form={form} />}

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Save'}
                    </button>
                    <Link href={base} className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
