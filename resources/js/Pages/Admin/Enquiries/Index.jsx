import { Link, router } from '@inertiajs/react';
import { Mail, MailOpen, Phone } from 'lucide-react';
import { Fragment, useState } from 'react';
import DataTable from '../../../Components/Admin/DataTable';
import ConfirmDelete from '../../../Components/Admin/ConfirmDelete';
import AdminLayout from '../../../Layouts/AdminLayout';

const fmt = (d) => new Date(d).toLocaleString('en-GB', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });

export default function EnquiriesIndex({ enquiries, filters, unreadCount }) {
    const [openId, setOpenId] = useState(null);

    const setStatus = (status) => router.get('/admin/enquiries', { q: filters.q, status: status || undefined }, { preserveState: true, replace: true });
    const toggleRead = (e) => router.patch(`/admin/enquiries/${e.id}/${e.read_at ? 'unread' : 'read'}`, {}, { preserveScroll: true });

    return (
        <AdminLayout title="Enquiries">
            <DataTable
                title="enquiries"
                basePath="/admin/enquiries"
                columns={[
                    { key: 'from', label: 'From' },
                    { key: 'subject', label: 'Subject' },
                    { key: 'country', label: 'Country' },
                    { key: 'created_at', label: 'Received' },
                ]}
                rows={enquiries}
                filters={filters}
                searchPlaceholder="Search name, email, company, country…"
                statusFilter={
                    <select value={filters.status || ''} onChange={(e) => setStatus(e.target.value)}
                            className="rounded-lg border border-ink-200 bg-white px-3 py-2 text-sm font-semibold text-ink-700">
                        <option value="">All ({enquiries.total})</option>
                        <option value="unread">Unread ({unreadCount})</option>
                        <option value="read">Read</option>
                    </select>
                }
                renderRow={(e) => (
                    <Fragment key={e.id}>
                        <tr onClick={() => setOpenId(openId === e.id ? null : e.id)}
                            className={`cursor-pointer hover:bg-ink-50/60 ${e.read_at ? '' : 'bg-brand-50/40'}`}>
                            <td className="px-4 py-3">
                                <div className="flex items-center gap-2">
                                    {!e.read_at && <span className="h-2 w-2 shrink-0 rounded-full bg-brand-500" aria-label="Unread" />}
                                    <div className="min-w-0">
                                        <p className={`truncate text-sm ${e.read_at ? 'text-ink-700' : 'font-bold text-ink-900'}`}>{e.name}</p>
                                        <p className="truncate text-xs text-ink-400">{e.email}{e.company ? ` · ${e.company}` : ''}</p>
                                    </div>
                                </div>
                            </td>
                            <td className="max-w-[200px] truncate px-4 py-3 text-sm text-ink-700">{e.subject || '—'}</td>
                            <td className="px-4 py-3 text-sm text-ink-700">{e.country || '—'}</td>
                            <td className="whitespace-nowrap px-4 py-3 text-xs text-ink-500">{fmt(e.created_at)}</td>
                            <td className="px-4 py-3 text-right" onClick={(ev) => ev.stopPropagation()}>
                                <div className="flex items-center justify-end gap-3">
                                    <button type="button" onClick={() => toggleRead(e)}
                                            className="text-xs font-bold text-ink-500 hover:text-brand-700" title={e.read_at ? 'Mark unread' : 'Mark read'}>
                                        {e.read_at ? <MailOpen size={15} aria-hidden /> : <Mail size={15} aria-hidden />}
                                    </button>
                                    <ConfirmDelete href={`/admin/enquiries/${e.id}`} name={`enquiry from ${e.name}`} />
                                </div>
                            </td>
                        </tr>
                        {openId === e.id && (
                            <tr className="bg-ink-50/40">
                                <td colSpan={5} className="px-6 py-5">
                                    <dl className="grid gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Name</dt><dd className="text-ink-800">{e.name}</dd></div>
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Company</dt><dd className="text-ink-800">{e.company || '—'}</dd></div>
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Email</dt>
                                            <dd><a href={`mailto:${e.email}?subject=Re: ${e.subject || 'Your enquiry'}`} className="font-semibold text-brand-700 hover:underline">{e.email}</a></dd></div>
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Phone</dt>
                                            <dd>{e.phone ? <a href={`tel:${e.phone}`} className="inline-flex items-center gap-1 font-semibold text-brand-700 hover:underline"><Phone size={12} aria-hidden />{e.phone}</a> : '—'}</dd></div>
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Country</dt><dd className="text-ink-800">{e.country || '—'}</dd></div>
                                        <div><dt className="text-xs font-bold uppercase text-ink-400">Product</dt>
                                            <dd className="text-ink-800">{e.product ? e.product.name : 'General enquiry'}</dd></div>
                                    </dl>
                                    <div className="mt-4">
                                        <p className="text-xs font-bold uppercase text-ink-400">Message</p>
                                        <p className="mt-1 whitespace-pre-line text-sm leading-relaxed text-ink-800">{e.message}</p>
                                    </div>
                                    <p className="mt-4 text-xs text-ink-400">IP: {e.ip_address || '—'} · {fmt(e.created_at)}</p>
                                </td>
                            </tr>
                        )}
                    </Fragment>
                )} />
        </AdminLayout>
    );
}
