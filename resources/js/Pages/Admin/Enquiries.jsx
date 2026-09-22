import { router } from '@inertiajs/react';
import { CheckCheck, ChevronLeft, ChevronRight, LogOut, Mail, MailOpen, Trash2 } from 'lucide-react';
import { useState } from 'react';
import Logo from '../../Components/Logo';

export default function AdminEnquiries({ enquiries, unread }) {
    const [openId, setOpenId] = useState(null);

    const markRead = (id) => router.patch(`/admin/enquiries/${id}/read`, {}, { preserveScroll: true });
    const remove = (id) => {
        if (confirm('Delete this enquiry permanently?')) {
            router.delete(`/admin/enquiries/${id}`, { preserveScroll: true });
        }
    };

    return (
        <div className="min-h-screen bg-ink-50">
            <header className="border-b border-ink-100 bg-white">
                <div className="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
                    <Logo />
                    <div className="flex items-center gap-4">
                        <span className="text-xs font-bold uppercase tracking-wider text-ink-500">
                            {unread} unread
                        </span>
                        <button onClick={() => router.post('/admin/logout')}
                                className="inline-flex items-center gap-1.5 rounded-lg border border-ink-200 px-3 py-1.5 text-xs font-bold text-ink-700 hover:bg-ink-50">
                            <LogOut size={13} /> Sign out
                        </button>
                    </div>
                </div>
            </header>

            <main className="mx-auto max-w-5xl px-4 py-8 sm:px-6">
                <h1 className="text-2xl font-extrabold text-ink-900">Enquiries</h1>
                <p className="mt-1 text-sm text-ink-500">Website contact-form submissions, newest first.</p>

                {enquiries.data.length === 0 ? (
                    <div className="mt-8 rounded-2xl border border-dashed border-ink-200 bg-white p-12 text-center">
                        <Mail size={28} className="mx-auto text-ink-300" />
                        <p className="mt-3 font-semibold text-ink-700">No enquiries yet</p>
                        <p className="mt-1 text-sm text-ink-500">New submissions from the contact page will appear here.</p>
                    </div>
                ) : (
                    <ul className="mt-8 space-y-3">
                        {enquiries.data.map((e) => {
                            const open = openId === e.id;
                            return (
                                <li key={e.id} className={`rounded-xl border bg-white shadow-card transition-colors ${e.read ? 'border-ink-100' : 'border-brand-300'}`}>
                                    <button type="button" onClick={() => { setOpenId(open ? null : e.id); if (!e.read) markRead(e.id); }}
                                            className="flex w-full items-center justify-between gap-4 px-5 py-4 text-left">
                                        <div className="flex min-w-0 items-center gap-3">
                                            {e.read
                                                ? <MailOpen size={17} className="shrink-0 text-ink-300" />
                                                : <Mail size={17} className="shrink-0 text-brand-600" />}
                                            <div className="min-w-0">
                                                <p className={`truncate text-sm ${e.read ? 'font-semibold text-ink-700' : 'font-bold text-ink-900'}`}>
                                                    {e.name}{e.company ? ` — ${e.company}` : ''}
                                                </p>
                                                <p className="truncate text-xs text-ink-500">{e.subject || 'General enquiry'}{e.product ? ` · ${e.product}` : ''}</p>
                                            </div>
                                        </div>
                                        <span className="shrink-0 text-xs font-medium text-ink-400">
                                            {new Date(e.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' })}
                                        </span>
                                    </button>
                                    {open && (
                                        <div className="border-t border-ink-100 px-5 py-4 text-sm">
                                            <dl className="grid gap-2 sm:grid-cols-2">
                                                <div><dt className="text-xs font-bold uppercase text-ink-400">Email</dt><dd><a href={`mailto:${e.email}`} className="font-semibold text-brand-700">{e.email}</a></dd></div>
                                                <div><dt className="text-xs font-bold uppercase text-ink-400">Phone</dt><dd>{e.phone || '—'}</dd></div>
                                                <div><dt className="text-xs font-bold uppercase text-ink-400">Country</dt><dd>{e.country || '—'}</dd></div>
                                                <div><dt className="text-xs font-bold uppercase text-ink-400">Received</dt><dd>{new Date(e.created_at).toLocaleString('en-GB')}</dd></div>
                                            </dl>
                                            <p className="mt-4 whitespace-pre-wrap rounded-lg bg-ink-50 p-4 leading-relaxed text-ink-800">{e.message}</p>
                                            <div className="mt-4 flex gap-2">
                                                <a href={`mailto:${e.email}?subject=Re: ${e.subject || 'Your enquiry to Nymak Pharma'}`}
                                                   className="rounded-lg bg-brand-700 px-4 py-2 text-xs font-bold text-white hover:bg-brand-800">
                                                    Reply by email
                                                </a>
                                                <button onClick={() => remove(e.id)}
                                                        className="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50">
                                                    <Trash2 size={13} /> Delete
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                </li>
                            );
                        })}
                    </ul>
                )}

                {enquiries.last_page > 1 && (
                    <nav aria-label="Enquiries pagination" className="mt-8 flex items-center justify-center gap-2">
                        {enquiries.links.map((l, i) => {
                            const label = l.label.includes('Previous') ? <ChevronLeft size={15} /> :
                                l.label.includes('Next') ? <ChevronRight size={15} /> : l.label;
                            return l.url ? (
                                <button key={i} onClick={() => router.get(l.url, {}, { preserveScroll: true })}
                                        className={`flex h-9 min-w-9 items-center justify-center rounded-lg px-3 text-sm font-bold ${l.active ? 'bg-brand-700 text-white' : 'border border-ink-200 bg-white text-ink-700'}`}>
                                    {label}
                                </button>
                            ) : <span key={i} className="px-2 text-sm text-ink-300">{label}</span>;
                        })}
                    </nav>
                )}
            </main>
        </div>
    );
}
