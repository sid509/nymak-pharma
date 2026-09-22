import { useForm } from '@inertiajs/react';
import { Loader2, LogIn } from 'lucide-react';
import Logo from '../../Components/Logo';

export default function AdminLogin() {
    const form = useForm({ email: '', password: '', remember: true });

    function submit(e) {
        e.preventDefault();
        form.post('/admin/login');
    }

    const inputCls = 'w-full rounded-lg border border-ink-200 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100';

    return (
        <div className="flex min-h-screen items-center justify-center bg-ink-50 px-4">
            <div className="w-full max-w-sm">
                <div className="mb-6 flex justify-center"><Logo /></div>
                <form onSubmit={submit} className="rounded-2xl border border-ink-100 bg-white p-7 shadow-card">
                    <h1 className="text-lg font-extrabold text-ink-900">Admin sign in</h1>
                    <p className="mt-1 text-sm text-ink-500">Nymak Pharma administration.</p>

                    <div className="mt-6 space-y-4">
                        <div>
                            <label htmlFor="email" className="mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-700">Email</label>
                            <input id="email" type="email" required autoComplete="email" autoFocus
                                   value={form.data.email} onChange={(e) => form.setData('email', e.target.value)}
                                   className={inputCls} />
                            {form.errors.email && <p className="mt-1 text-xs font-semibold text-red-600" role="alert">{form.errors.email}</p>}
                        </div>
                        <div>
                            <label htmlFor="password" className="mb-1.5 block text-xs font-bold uppercase tracking-wider text-ink-700">Password</label>
                            <input id="password" type="password" required autoComplete="current-password"
                                   value={form.data.password} onChange={(e) => form.setData('password', e.target.value)}
                                   className={inputCls} />
                            {form.errors.password && <p className="mt-1 text-xs font-semibold text-red-600" role="alert">{form.errors.password}</p>}
                        </div>
                        <button type="submit" disabled={form.processing}
                                className="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-brand-800 disabled:opacity-60">
                            {form.processing ? <Loader2 size={16} className="animate-spin" /> : <LogIn size={16} />}
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
