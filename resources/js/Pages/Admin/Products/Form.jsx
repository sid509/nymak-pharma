import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field, { inputCls } from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function ProductForm({ product = null, categories, markets }) {
    const isEdit = !!product;
    const form = useForm({
        name: product?.name || '',
        slug: product?.slug || '',
        product_category_id: product?.product_category_id || '',
        market_id: product?.market_id || '',
        therapeutic_group: product?.therapeutic_group || '',
        strength: product?.strength || '',
        pack_size: product?.pack_size || '',
        specimen: product?.specimen || '',
        description: product?.description || '',
        image: null,
        has_detail_page: product?.has_detail_page ?? false,
        meta_title: product?.meta_title || '',
        meta_description: product?.meta_description || '',
        sort_order: product?.sort_order ?? 0,
        _method: isEdit ? 'PUT' : 'POST',
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        // forceFormData for the file upload; _method handles PUT spoofing.
        form.post(isEdit ? `/admin/products/${product.slug}` : '/admin/products', { forceFormData: true });
    };

    const f = (name, label, extra = {}) => (
        <Field field={{ name, label, ...extra }} value={form.data[name]} error={form.errors[name]} onChange={set} />
    );

    return (
        <AdminLayout title={isEdit ? `Edit: ${product.name}` : 'New product'}>
            <form onSubmit={submit} className="max-w-3xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">Basics</h2>
                    <div className="grid gap-5 sm:grid-cols-2">
                        {f('name', 'Product name', { required: true })}
                        {f('slug', 'URL slug', { help: 'Auto-generated from the name if left blank.' })}
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'product_category_id', label: 'Category', type: 'select', required: true,
                            options: categories.map((c) => ({ value: c.id, label: c.name })) }}
                               value={form.data.product_category_id} error={form.errors.product_category_id} onChange={set} />
                        <Field field={{ name: 'market_id', label: 'Market', type: 'select',
                            options: markets.map((m) => ({ value: m.id, label: m.name })) }}
                               value={form.data.market_id} error={form.errors.market_id} onChange={set} />
                    </div>
                    {f('description', 'Description', { type: 'textarea', rows: 4, help: 'Shown on the public detail page when enabled.' })}
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">Specifications</h2>
                    <div className="grid gap-5 sm:grid-cols-2">
                        {f('therapeutic_group', 'Therapeutic group')}
                        {f('strength', 'Strength')}
                        {f('pack_size', 'Pack size')}
                        {f('specimen', 'Specimen / presentation')}
                    </div>
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">Image & visibility</h2>
                    {product?.image && (
                        <div className="flex items-center gap-3">
                            <img src={`/${product.image}`} alt="" className="h-16 w-16 rounded-lg border border-ink-100 bg-white object-contain" />
                            <p className="text-xs text-ink-400">Current image — upload a new one to replace it.</p>
                        </div>
                    )}
                    <div>
                        <label htmlFor="f-image" className="mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-600">Product image</label>
                        <input id="f-image" type="file" accept="image/jpeg,image/png,image/webp"
                               onChange={(e) => set('image', e.target.files[0] || null)}
                               className={`${inputCls} file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-800`} />
                        <p className="mt-1.5 text-xs text-ink-400">JPEG, PNG or WebP up to 2 MB — converted to WebP automatically.</p>
                        {form.errors.image && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{form.errors.image}</p>}
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        {f('has_detail_page', 'Public detail page', { type: 'checkbox', help: 'Enable to publish a dedicated SEO page for this product.' })}
                        {f('sort_order', 'Sort order', { type: 'number' })}
                    </div>
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">SEO</h2>
                    <p className="-mt-2 text-xs text-ink-400">Leave blank to auto-derive from name and description.</p>
                    {f('meta_title', 'Meta title', { help: `${(form.data.meta_title || '').length}/70` })}
                    {f('meta_description', 'Meta description', { type: 'textarea', rows: 2, help: `${(form.data.meta_description || '').length}/200` })}
                </section>

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create product'}
                    </button>
                    <Link href="/admin/products" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
