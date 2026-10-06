import Field from './Field';

const LOCALES = [
    ['fr', 'Français (French)', 'FR'],
    ['es', 'Español (Spanish)', 'ES'],
];

/**
 * French + Spanish inputs for a model's translatable fields. Values post as
 * `i18n.fr.<field>` / `i18n.es.<field>`; the model merges them into its JSON
 * `i18n` column. Blank fields fall back to the English value on the site.
 */
export default function TranslationFields({ fields, form, data }) {
    const set = (locale, name, v) => form.setData(`i18n.${locale}.${name}`, v);
    const i18n = form.data.i18n || {};

    return (
        <section className="space-y-6 rounded-2xl border border-ink-200 bg-white p-6 sm:p-8">
            <div>
                <h2 className="text-sm font-bold uppercase tracking-wider text-ink-500">Translations</h2>
                <p className="mt-1 text-xs text-ink-400">
                    Optional French and Spanish versions shown on the /fr and /es site.
                    Leave a field blank to fall back to the English text above.
                </p>
            </div>
            {LOCALES.map(([locale, legend, tag]) => (
                <fieldset key={locale} className="space-y-4 rounded-xl border border-ink-100 bg-ink-50/40 p-4">
                    <legend className="rounded-full bg-ink-800 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white">
                        {legend}
                    </legend>
                    {fields.map((f) => (
                        <Field key={`${locale}.${f.name}`}
                               field={{ ...f, name: `i18n.${locale}.${f.name}`, label: `${f.label} (${tag})`, required: false }}
                               value={i18n[locale]?.[f.name] ?? ''}
                               error={form.errors[`i18n.${locale}.${f.name}`]}
                               onChange={(_, v) => set(locale, f.name, v)} />
                    ))}
                </fieldset>
            ))}
        </section>
    );
}
