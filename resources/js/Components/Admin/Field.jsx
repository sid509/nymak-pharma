import { lazy, Suspense } from 'react';

// Loaded on demand — TipTap is heavy and only rich-text forms need it.
const RichText = lazy(() => import('./RichText'));
const richtextFallback = <div className="min-h-[17rem] animate-pulse rounded-lg border border-ink-200 bg-ink-50" aria-hidden />;

export const inputCls = 'w-full rounded-lg border border-ink-200 bg-white px-3.5 py-2.5 text-sm text-ink-900 placeholder:text-ink-400 transition-colors focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100';
const labelCls = 'mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-600';

/**
 * Admin form field — label, input by type, help text, server error display.
 */
export default function Field({ field, value, error, onChange }) {
    const { name, label, type = 'text', required, help, options = [], rows = 4 } = field;

    if (type === 'checkbox') {
        return (
            <div>
                <label className="flex items-center gap-2.5 text-sm font-semibold text-ink-800">
                    <input type="checkbox" checked={!!value} onChange={(e) => onChange(name, e.target.checked)}
                           className="h-4 w-4 rounded border-ink-300 text-brand-700 focus:ring-brand-500" />
                    {label}
                </label>
                {help && <p className="mt-1 text-xs text-ink-400">{help}</p>}
                {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
            </div>
        );
    }

    if (type === 'file') {
        const current = field.preview ?? (typeof value === 'string' ? value : null);
        return (
            <div>
                <label htmlFor={`f-${name}`} className={labelCls}>
                    {label}{required && <span className="ml-0.5 text-red-600" aria-hidden>*</span>}
                </label>
                {current && (
                    <p className="mb-2 text-xs text-ink-500">
                        Current: <a href={`/${current}`} target="_blank" rel="noopener noreferrer" className="font-bold text-brand-700 underline">{current}</a>
                    </p>
                )}
                <input id={`f-${name}`} type="file" accept="application/pdf"
                       onChange={(e) => onChange(name, e.target.files[0] || null)}
                       className={`${inputCls} file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-800`} />
                <p className="mt-1.5 text-xs text-ink-400">{help || 'PDF up to 10 MB.'}</p>
                {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
            </div>
        );
    }

    if (type === 'image') {
        // value = current stored path; field.preview carries the same for edit screens
        const current = field.preview ?? (typeof value === 'string' ? value : null);
        return (
            <div>
                <label htmlFor={`f-${name}`} className={labelCls}>
                    {label}{required && <span className="ml-0.5 text-red-600" aria-hidden>*</span>}
                </label>
                {current && (
                    <div className="mb-2 flex items-center gap-3">
                        <img src={`/${current}`} alt="" className="h-14 w-14 rounded-lg border border-ink-100 bg-white object-contain" />
                        <p className="text-xs text-ink-400">Current image — choose a file to replace.</p>
                    </div>
                )}
                <input id={`f-${name}`} type="file" accept="image/jpeg,image/png,image/webp"
                       onChange={(e) => onChange(name, e.target.files[0] || null)}
                       className={`${inputCls} file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-800`} />
                <p className="mt-1.5 text-xs text-ink-400">{help || 'JPEG, PNG or WebP up to 2 MB — converted to WebP.'}</p>
                {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
            </div>
        );
    }

    const control =
        type === 'richtext' ? (
            <Suspense fallback={richtextFallback}>
                <RichText id={`f-${name}`} value={value ?? ''} onChange={(v) => onChange(name, v)} placeholder={field.placeholder} />
            </Suspense>
        ) : type === 'textarea' ? (
            <textarea id={`f-${name}`} rows={rows} value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls} />
        ) : type === 'select' ? (
            <select id={`f-${name}`} value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls}>
                <option value="">—</option>
                {options.map((o) => <option key={o.value} value={o.value}>{o.label}</option>)}
            </select>
        ) : (
            <input id={`f-${name}`} type={type} value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls} />
        );

    return (
        <div>
            <label htmlFor={`f-${name}`} className={labelCls}>
                {label}{required && <span className="ml-0.5 text-red-600" aria-hidden>*</span>}
            </label>
            {control}
            {help && <p className="mt-1.5 text-xs text-ink-400">{help}</p>}
            {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
        </div>
    );
}
