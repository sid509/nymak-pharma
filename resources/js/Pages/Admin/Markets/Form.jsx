import { Link, useForm } from '@inertiajs/react';
import { Loader2, Save } from 'lucide-react';
import Field from '../../../Components/Admin/Field';
import TranslationFields from '../../../Components/Admin/TranslationFields';
import { COUNTRIES } from '../../../data/countries';
import AdminLayout from '../../../Layouts/AdminLayout';

const countryOptions = Object.entries(COUNTRIES)
    .map(([code, [, name]]) => ({ value: code, label: `${name} (${code})` }))
    .sort((a, b) => a.label.localeCompare(b.label));

export default function MarketForm({ market = null }) {
    const isEdit = !!market;
    const form = useForm({
        name: market?.name || '',
        slug: market?.slug || '',
        iso_code: market?.iso_code || '',
        region: market?.region || '',
        description: market?.description || '',
        content: market?.content || '',
        latitude: market?.latitude ?? '',
        longitude: market?.longitude ?? '',
        show_in_portfolio: market?.show_in_portfolio ?? false,
        sort_order: market?.sort_order ?? 0,
        i18n: market?.i18n ?? {},
    });

    const set = (k, v) => form.setData(k, v);
    const submit = (e) => {
        e.preventDefault();
        isEdit ? form.put(`/admin/markets/${market.slug}`) : form.post('/admin/markets');
    };

    return (
        <AdminLayout title={isEdit ? `Edit: ${market.name}` : 'New market'}>
            <form onSubmit={submit} className="max-w-3xl space-y-6">
                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'name', label: 'Country / market', required: true }} value={form.data.name} error={form.errors.name} onChange={set} />
                        <Field field={{ name: 'slug', label: 'URL slug', help: 'Auto-generated from name if blank.' }} value={form.data.slug} error={form.errors.slug} onChange={set} />
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'iso_code', label: 'Country on map', type: 'select', options: countryOptions, help: 'Highlights this country on the Global Presence map. Leave blank for a multi-country region and set a pin below.' }} value={form.data.iso_code} error={form.errors.iso_code} onChange={set} />
                        <Field field={{ name: 'region', label: 'Region', help: 'e.g. West Africa' }} value={form.data.region} error={form.errors.region} onChange={set} />
                    </div>
                    <Field field={{ name: 'description', label: 'Short summary', type: 'textarea', rows: 2, help: 'One or two plain sentences — shown on hover and in the market list.' }} value={form.data.description} error={form.errors.description} onChange={set} />
                    <Field field={{ name: 'content', label: 'What we do in this market', type: 'richtext', placeholder: 'Describe the work, partners, registrations and products in this country…', help: 'Shown in the detail panel when the country is selected on the map. Headings, lists, bold and links are supported.' }} value={form.data.content} error={form.errors.content} onChange={set} />
                </section>

                <section className="space-y-5 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
                    <div>
                        <h2 className="text-sm font-bold text-ink-900">Map pin (optional)</h2>
                        <p className="mt-1 text-xs text-ink-400">
                            Place a pin by coordinates when the market is not a single country (e.g. an island group), or to move the marker off the country centroid.
                        </p>
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'latitude', label: 'Latitude', type: 'number', help: '-90 to 90, e.g. -17.7' }} value={form.data.latitude} error={form.errors.latitude} onChange={set} />
                        <Field field={{ name: 'longitude', label: 'Longitude', type: 'number', help: '-180 to 180, e.g. 178.0' }} value={form.data.longitude} error={form.errors.longitude} onChange={set} />
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field field={{ name: 'show_in_portfolio', label: 'Key market', type: 'checkbox', help: 'Highlights the country more strongly and lists it first with its supplied products.' }} value={form.data.show_in_portfolio} error={form.errors.show_in_portfolio} onChange={set} />
                        <Field field={{ name: 'sort_order', label: 'Sort order', type: 'number' }} value={form.data.sort_order} error={form.errors.sort_order} onChange={set} />
                    </div>
                </section>

                <TranslationFields form={form} fields={[
                    { name: 'name', label: 'Country / market' },
                    { name: 'region', label: 'Region' },
                    { name: 'description', label: 'Short summary', type: 'textarea', rows: 2 },
                    { name: 'content', label: 'What we do in this market', type: 'richtext' },
                    { name: 'meta_title', label: 'Meta title' },
                    { name: 'meta_description', label: 'Meta description', type: 'textarea', rows: 2 },
                ]} />

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
