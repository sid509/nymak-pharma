import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function CategoryForm({ category }) {
    const form = useForm({
        name: category.name,
        icon: category.icon || '',
        intro: category.intro || '',
        description: category.description || '',
        content: category.content || '',
        image: null,
        meta_title: category.meta_title || '',
        meta_description: category.meta_description || '',
        sort_order: category.sort_order ?? 0,
        _method: 'PUT',
    });

    const set = (k, v) => form.setData(k, v);
    // forceFormData for the image upload; _method handles PUT spoofing.
    const submit = (e) => { e.preventDefault(); form.post(`/admin/categories/${category.slug}`, { forceFormData: true }); };

    return (
        <AdminLayout title={`Edit category: ${category.name}`}>
            <form onSubmit={submit} className="max-w-2xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <div className="flex items-center justify-between">
                        <h2 className="text-sm font-bold uppercase tracking-wider text-ink-500">Content</h2>
                        <code className="rounded bg-ink-50 px-2 py-0.5 text-xs text-ink-500">/product/{category.slug}</code>
                    </div>
                    <Field field={{ name: 'name', label: 'Name', required: true }} value={form.data.name} error={form.errors.name} onChange={set} />
                    <Field field={{ name: 'icon', label: 'Icon', help: 'Lucide icon name (e.g. FlaskConical)' }} value={form.data.icon} error={form.errors.icon} onChange={set} />
                    <Field field={{ name: 'intro', label: 'Intro', type: 'textarea', rows: 2, help: 'One or two sentences — hero lead on the category page and the card text on Home / Products.' }} value={form.data.intro} error={form.errors.intro} onChange={set} />
                    <Field field={{ name: 'image', label: 'Category image', type: 'image', preview: category.image, help: 'Optional — shown on the category page. JPEG, PNG or WebP up to 2 MB.' }} value={form.data.image} error={form.errors.image} onChange={set} />
                    <Field field={{ name: 'content', label: 'Category page content', type: 'richtext', placeholder: 'What this range is, who it serves, how it is manufactured and registered…', help: 'The main body of the category landing page. Headings, lists, bold and links are supported. Aim for 300+ words for SEO.' }} value={form.data.content} error={form.errors.content} onChange={set} />
                    <Field field={{ name: 'description', label: 'Fallback description (plain text)', type: 'textarea', rows: 4, help: 'Used only when the page content above is empty.' }} value={form.data.description} error={form.errors.description} onChange={set} />
                    <Field field={{ name: 'sort_order', label: 'Sort order', type: 'number' }} value={form.data.sort_order} error={form.errors.sort_order} onChange={set} />
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-bold uppercase tracking-wider text-ink-500">SEO</h2>
                    <Field field={{ name: 'meta_title', label: 'Meta title', help: `${(form.data.meta_title || '').length}/70` }} value={form.data.meta_title} error={form.errors.meta_title} onChange={set} />
                    <Field field={{ name: 'meta_description', label: 'Meta description', type: 'textarea', rows: 2, help: `${(form.data.meta_description || '').length}/200` }} value={form.data.meta_description} error={form.errors.meta_description} onChange={set} />
                </section>

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : 'Save changes'}
                    </button>
                    <Link href="/admin/categories" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
