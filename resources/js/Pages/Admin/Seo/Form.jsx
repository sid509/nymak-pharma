import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field, { inputCls } from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function SeoForm({ page }) {
    const form = useForm({
        meta_title: page.meta_title || '',
        meta_description: page.meta_description || '',
        og_image: null,
        _method: 'PUT',
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        form.post(`/admin/seo-pages/${page.id}`, { forceFormData: true });
    };

    return (
        <AdminLayout title={`SEO: ${page.label}`}>
            <form onSubmit={submit} className="max-w-2xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <p className="text-xs text-ink-400">
                        Blank fields use the built-in defaults — which are already tuned per page.
                        Title ≤70 chars; description ≤300 chars (search snippets trim ~150).
                    </p>
                    <Field field={{ name: 'meta_title', label: 'Meta title',
                        help: `${(form.data.meta_title || '').length}/70` }}
                        value={form.data.meta_title} error={form.errors.meta_title} onChange={set} />
                    <Field field={{ name: 'meta_description', label: 'Meta description', type: 'textarea', rows: 3,
                        help: `${(form.data.meta_description || '').length}/300` }}
                        value={form.data.meta_description} error={form.errors.meta_description} onChange={set} />

                    {page.og_image && (
                        <div className="flex items-center gap-3">
                            <img src={`/${page.og_image}`} alt="" className="h-14 w-24 rounded-lg border border-ink-100 object-cover" />
                            <p className="text-xs text-ink-400">Current social image — upload to replace.</p>
                        </div>
                    )}
                    <div>
                        <label htmlFor="f-og" className="mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-600">Social share image (OG)</label>
                        <input id="f-og" type="file" accept="image/jpeg,image/png,image/webp"
                               onChange={(e) => set('og_image', e.target.files[0] || null)}
                               className={`${inputCls} file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-800`} />
                        <p className="mt-1.5 text-xs text-ink-400">1200×630 recommended. Converted to WebP.</p>
                        {form.errors.og_image && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{form.errors.og_image}</p>}
                    </div>
                </section>

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Save SEO settings'}
                    </button>
                    <Link href="/admin/seo-pages" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
