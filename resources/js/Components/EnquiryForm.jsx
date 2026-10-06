import { useForm, usePage } from '@inertiajs/react';
import { Loader2, Send } from 'lucide-react';

const inputCls = 'w-full rounded-lg border border-ink-200 bg-white px-3.5 py-2.5 text-sm text-ink-900 placeholder:text-ink-400 transition-colors focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100';
const labelCls = 'mb-1.5 block t-eyebrow text-ink-700';

function Field({ label, error, required, children }) {
    return (
        <div>
            <label className={labelCls}>
                {label}{required && <span className="ml-0.5 text-red-600" aria-hidden>*</span>}
            </label>
            {children}
            {error && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{error}</p>}
        </div>
    );
}

export default function EnquiryForm({ products = [], formStartedAt, honeypot = 'website_url', selectedProduct = null, compact = false }) {
    const { site } = usePage().props;
    const form = useForm({
        name: '', company: '', email: '', phone: '', country: '',
        subject: '', message: '', product_id: selectedProduct || '', privacy: false,
        [honeypot]: '', form_started_at: formStartedAt || Math.floor(Date.now() / 1000),
    });

    function submit(e) {
        e.preventDefault();
        form.post('/contact', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                if (window.nymakTrack) window.nymakTrack('generate_lead', { method: 'form' });
            },
        });
    }

    return (
        <form onSubmit={submit} noValidate={false} className="space-y-4">
            {/* Honeypot — hidden from humans, bots fill it */}
            <div aria-hidden="true" className="absolute -left-[9999px] h-0 w-0 overflow-hidden">
                <label htmlFor={honeypot}>Website</label>
                <input id={honeypot} name={honeypot} type="text" tabIndex={-1} autoComplete="off"
                       data-1p-ignore data-lpignore="true" data-form-type="other"
                       value={form.data[honeypot]} onChange={(e) => form.setData(honeypot, e.target.value)} />
            </div>

            <div className={`grid gap-4 ${compact ? '' : 'sm:grid-cols-2'}`}>
                <Field label="Full Name" error={form.errors.name} required>
                    <input id="f-name" type="text" required autoComplete="name"
                           value={form.data.name} onChange={(e) => form.setData('name', e.target.value)}
                           className={inputCls} placeholder="Your name" />
                </Field>
                <Field label="Company / Organisation" error={form.errors.company}>
                    <input id="f-company" type="text" autoComplete="organization"
                           value={form.data.company} onChange={(e) => form.setData('company', e.target.value)}
                           className={inputCls} placeholder="Company name" />
                </Field>
            </div>

            <div className={`grid gap-4 ${compact ? '' : 'sm:grid-cols-2'}`}>
                <Field label="Business Email" error={form.errors.email} required>
                    <input id="f-email" type="email" required autoComplete="email"
                           value={form.data.email} onChange={(e) => form.setData('email', e.target.value)}
                           className={inputCls} placeholder="you@company.com" />
                </Field>
                <Field label="Phone / WhatsApp" error={form.errors.phone}>
                    <input id="f-phone" type="tel" autoComplete="tel"
                           value={form.data.phone} onChange={(e) => form.setData('phone', e.target.value)}
                           className={inputCls} placeholder="+231 ..." />
                </Field>
            </div>

            <div className={`grid gap-4 ${compact ? '' : 'sm:grid-cols-2'}`}>
                <Field label="Country" error={form.errors.country}>
                    <input id="f-country" type="text" autoComplete="country-name"
                           value={form.data.country} onChange={(e) => form.setData('country', e.target.value)}
                           className={inputCls} placeholder="Destination market" />
                </Field>
                <Field label="Product of Interest" error={form.errors.product_id}>
                    <select id="f-product" value={form.data.product_id}
                            onChange={(e) => form.setData('product_id', e.target.value)} className={inputCls}>
                        <option value="">General enquiry</option>
                        {products.map((p) => <option key={p.id} value={p.id}>{p.name}</option>)}
                    </select>
                </Field>
            </div>

            <Field label="Subject" error={form.errors.subject}>
                <input id="f-subject" type="text"
                       value={form.data.subject} onChange={(e) => form.setData('subject', e.target.value)}
                       className={inputCls} placeholder="e.g. Distribution enquiry — IV fluids" />
            </Field>

            <Field label="Message" error={form.errors.message} required>
                <textarea id="f-message" rows={compact ? 4 : 5} required
                          value={form.data.message} onChange={(e) => form.setData('message', e.target.value)}
                          className={inputCls} placeholder="Tell us about your requirement — products, quantities, destination market..." />
            </Field>

            <div>
                <label className="flex items-start gap-2.5 text-xs leading-relaxed text-ink-600">
                    <input type="checkbox" checked={form.data.privacy}
                           onChange={(e) => form.setData('privacy', e.target.checked)}
                           className="mt-0.5 h-4 w-4 rounded border-ink-300 text-brand-700 focus:ring-brand-500" />
                    <span>I agree to the <a href="/privacy-policy" className="font-semibold text-brand-700 underline">privacy policy</a> and consent to {site.name} contacting me about this enquiry.</span>
                </label>
                {form.errors.privacy && <p className="mt-1.5 text-xs font-semibold text-red-600" role="alert">{form.errors.privacy}</p>}
            </div>

            <button type="submit" disabled={form.processing}
                    className="btn-cta inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 px-6 py-2.5 t-button text-white transition-colors hover:bg-brand-700 disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                {form.processing ? <Loader2 size={16} className="animate-spin" aria-hidden /> : <Send size={16} aria-hidden />}
                {form.processing ? 'Sending…' : 'Send Enquiry'}
            </button>
        </form>
    );
}
