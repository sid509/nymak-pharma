import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

const TRANSLATABLE = ['text', 'textarea', 'richtext'];
const LOCALES = [['fr', 'FR'], ['es', 'ES']];

/**
 * Page content editor — renders the page's slot schema. Image slots upload
 * files (stored path overrides the default); text slots save verbatim;
 * clearing a text field restores its default. Toggles show/hide sections;
 * richtext slots use the WYSIWYG editor. Text/textarea/richtext slots also
 * carry optional French/Spanish values for the /fr and /es site.
 */
export default function PageForm({ page, fields, values, stored, i18nValues = {} }) {
    const initial = Object.fromEntries(fields.map((f) => [
        f.name,
        f.type === 'image' ? null
            : f.type === 'json' ? JSON.stringify(values[f.name] ?? [], null, 2)
            : f.type === 'toggle' ? !!values[f.name]
            : values[f.name] ?? '',
    ]));
    // i18n.<slot>.<locale> mirrors PageContent's JSON column shape per field.
    const i18n = Object.fromEntries(fields.filter((f) => TRANSLATABLE.includes(f.type)).map((f) => [
        f.name,
        { fr: i18nValues[f.name]?.fr?.value ?? '', es: i18nValues[f.name]?.es?.value ?? '' },
    ]));
    const form = useForm({ ...initial, i18n, _method: 'PUT' });

    const submit = (e) => {
        e.preventDefault();
        form.post(`/admin/pages/${page.key}`, { forceFormData: true });
    };

    return (
        <AdminLayout title={`Content: ${page.label}`}>
            <form onSubmit={submit} className="max-w-3xl space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                <p className="text-xs text-ink-400">
                    Changes publish immediately to the live page. Clear a text field to restore its default.
                    Where you see <code className="rounded bg-ink-50 px-1">{'{category}'}</code> or <code className="rounded bg-ink-50 px-1">{'{count}'}</code>, the live page fills in the real value.
                    FR/ES fields are optional — blank falls back to English.
                </p>
                {fields.map((f) => (
                    <div key={f.name}>
                        <Field field={{ ...f,
                               type: f.type === 'json' ? 'textarea' : f.type === 'toggle' ? 'checkbox' : f.type,
                               rows: f.type === 'json' ? 10 : f.rows,
                               preview: f.type === 'image' ? values[f.name] : null,
                               help: f.help || (f.type === 'toggle' ? 'Untick to hide this on the live page.' : stored[f.name] == null ? 'Default value shown.' : 'Custom value saved.') }}
                           value={form.data[f.name]}
                           error={form.errors[f.name]}
                           onChange={(k, v) => form.setData(k, v)} />
                        {TRANSLATABLE.includes(f.type) && (
                            <div className="mt-2 grid gap-3 rounded-xl border border-ink-100 bg-ink-50/50 p-3 sm:grid-cols-2">
                                {LOCALES.map(([locale, tag]) => (
                                    <Field key={locale}
                                           field={{
                                               name: `i18n.${f.name}.${locale}`,
                                               label: `${f.label} (${tag})`,
                                               type: f.type === 'richtext' ? 'richtext' : f.type,
                                               rows: f.type === 'textarea' ? Math.min(f.rows ?? 4, 4) : f.rows,
                                           }}
                                           value={form.data.i18n?.[f.name]?.[locale] ?? ''}
                                           error={form.errors[`i18n.${f.name}.${locale}`]}
                                           onChange={(_, v) => form.setData(`i18n.${f.name}.${locale}`, v)} />
                                ))}
                            </div>
                        )}
                    </div>
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
