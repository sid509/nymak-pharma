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

    const control =
        type === 'textarea' ? (
            <textarea rows={rows} value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls} />
        ) : type === 'select' ? (
            <select value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls}>
                <option value="">—</option>
                {options.map((o) => <option key={o.value} value={o.value}>{o.label}</option>)}
            </select>
        ) : (
            <input type={type} value={value ?? ''} onChange={(e) => onChange(name, e.target.value)} className={inputCls} />
        );

    return (
        <div>
            <label htmlFor={`f-${name}`} className={labelCls}>
                {label}{required && <span className="ml-0.5 text-red-600" aria-hidden>*</span>}
            </label>
            <span id={`f-${name}`} className="block">{control}</span>
            {help && <p className="mt-1.5 text-xs text-ink-400">{help}</p>}
            {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
        </div>
    );
}
