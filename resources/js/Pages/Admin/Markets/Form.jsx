import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function MarketForm({ market = null }) {
    const isEdit = !!market;
    const form = useForm({
        name: market?.name || '',
        slug: market?.slug || '',
        iso_code: market?.iso_code || '',
        region: market?.region || '',
        description: market?.description || '',
        has_page: market?.has_page ?? false,
        meta_title: market?.meta_title || '',
        meta_description: market?.meta_description || '',
        sort_order: market?.sort_order ?? 0,
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        isEdit ? form.put(`/admin/markets/${market.slug}`) : form.post('/admin/markets');
    };

    return (
        <AdminLayout title={isEdit ? `Edit: ${market.name}` : 'New market'}>
            <form onSubmit={submit} className="max-w-2xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'name', label: 'Country / market', required: true }} value={form.data.name} error={form.errors.name} onChange={set} />
                        <Field field={{ name: 'slug', label: 'URL slug', help: 'Auto-generated from name if blank.' }} value={form.data.slug} error={form.errors.slug} onChange={set} />
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'iso_code', label: 'ISO code', help: 'e.g. SL, LR, NG' }} value={form.data.iso_code} error={form.errors.iso_code} onChange={set} />
                        <Field field={{ name: 'region', label: 'Region', help: 'e.g. West Africa' }} value={form.data.region} error={form.errors.region} onChange={set} />
                    </div>
                    <Field field={{ name: 'description', label: 'Market description', type: 'textarea', rows: 5, help: 'Markdown supported — required for a public page.' }} value={form.data.description} error={form.errors.description} onChange={set} />
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'has_page', label: 'Public market page', type: 'checkbox', help: 'Publish /global-presence/{slug} — only enable with real unique content.' }} value={form.data.has_page} error={form.errors.has_page} onChange={set} />
                        <Field field={{ name: 'sort_order', label: 'Sort order', type: 'number' }} value={form.data.sort_order} error={form.errors.sort_order} onChange={set} />
                    </div>
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">SEO</h2>
                    <Field field={{ name: 'meta_title', label: 'Meta title', help: `${(form.data.meta_title || '').length}/70 — blank derives from market name.` }} value={form.data.meta_title} error={form.errors.meta_title} onChange={set} />
                    <Field field={{ name: 'meta_description', label: 'Meta description', type: 'textarea', rows: 2, help: `${(form.data.meta_description || '').length}/300` }} value={form.data.meta_description} error={form.errors.meta_description} onChange={set} />
                </section>

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create market'}
                    </button>
                    <Link href="/admin/markets" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
