import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field, { inputCls } from '../../../Components/Admin/Field';
import AdminLayout from '../../../Layouts/AdminLayout';

export default function PostForm({ post = null }) {
    const isEdit = !!post;
    const form = useForm({
        title: post?.title || '',
        slug: post?.slug || '',
        category: post?.category || '',
        excerpt: post?.excerpt || '',
        body: post?.body || '',
        cover_image: null,
        published_at: post?.published_at ? post.published_at.slice(0, 16) : '',
        meta_title: post?.meta_title || '',
        meta_description: post?.meta_description || '',
        _method: isEdit ? 'PUT' : 'POST',
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        form.post(isEdit ? `/admin/posts/${post.slug}` : '/admin/posts', { forceFormData: true });
    };

    return (
        <AdminLayout title={isEdit ? `Edit: ${post.title}` : 'New article'}>
            <form onSubmit={submit} className="max-w-3xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">Article</h2>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'title', label: 'Title', required: true }} value={form.data.title} error={form.errors.title} onChange={set} />
                        <Field field={{ name: 'slug', label: 'URL slug', help: 'Auto-generated from the title if blank.' }} value={form.data.slug} error={form.errors.slug} onChange={set} />
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'category', label: 'Category', help: 'e.g. Quality, Export, Products' }} value={form.data.category} error={form.errors.category} onChange={set} />
                        <Field field={{ name: 'published_at', label: 'Publish at', type: 'datetime-local', help: 'Blank = draft (not publicly visible).' }} value={form.data.published_at} error={form.errors.published_at} onChange={set} />
                    </div>
                    <Field field={{ name: 'excerpt', label: 'Excerpt', type: 'textarea', rows: 2, help: 'Card + meta fallback.' }} value={form.data.excerpt} error={form.errors.excerpt} onChange={set} />
                    <Field field={{ name: 'body', label: 'Body', type: 'textarea', rows: 14, help: 'Markdown: ## headings, - lists, **bold**, [links](url).' }} value={form.data.body} error={form.errors.body} onChange={set} />

                    {post?.cover_image && (
                        <div className="flex items-center gap-3">
                            <img src={`/${post.cover_image}`} alt="" className="h-14 w-24 rounded-lg border border-ink-100 object-cover" />
                            <p className="text-xs text-ink-400">Current cover — upload to replace.</p>
                        </div>
                    )}
                    <div>
                        <label htmlFor="f-cover" className="mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-600">Cover image</label>
                        <input id="f-cover" type="file" accept="image/jpeg,image/png,image/webp"
                               onChange={(e) => set('cover_image', e.target.files[0] || null)}
                               className={`${inputCls} file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-800`} />
                        <p className="mt-1.5 text-xs text-ink-400">Used for cards, OG share image and Article schema. JPEG/PNG/WebP ≤2 MB.</p>
                        {form.errors.cover_image && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{form.errors.cover_image}</p>}
                    </div>
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <h2 className="text-sm font-extrabold uppercase tracking-wider text-ink-500">SEO</h2>
                    <Field field={{ name: 'meta_title', label: 'Meta title', help: `${(form.data.meta_title || '').length}/70 — blank derives from title.` }} value={form.data.meta_title} error={form.errors.meta_title} onChange={set} />
                    <Field field={{ name: 'meta_description', label: 'Meta description', type: 'textarea', rows: 2, help: `${(form.data.meta_description || '').length}/200` }} value={form.data.meta_description} error={form.errors.meta_description} onChange={set} />
                </section>

                <div className="flex items-center gap-3">
                    <button type="submit" disabled={form.processing}
                            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                        {form.processing ? <Loader2 size={15} className="animate-spin" aria-hidden /> : <Save size={15} aria-hidden />}
                        {form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create article'}
                    </button>
                    <Link href="/admin/posts" className="text-sm font-bold text-ink-500 hover:text-ink-800">Cancel</Link>
                </div>
            </form>
        </AdminLayout>
    );
}
