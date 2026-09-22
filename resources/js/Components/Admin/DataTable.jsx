import { Link, router } from '@inertiajs/react';
import { Plus, Search } from 'lucide-react';
import { useState } from 'react';

/**
 * Shared admin index table: search box, status filter slots, paginated rows,
 * row actions, empty state. Server-side pagination via Inertia links.
 */
export default function DataTable({
    title, createHref, createLabel, columns, rows, filters = {}, basePath,
    searchPlaceholder = 'Search…', statusFilter = null, renderRow,
}) {
    const [q, setQ] = useState(filters.q || '');

    const applyFilters = (overrides = {}) => {
        router.get(basePath, { q: q || undefined, status: filters.status, ...overrides },
            { preserveState: true, replace: true });
    };

    const cell = (row, col) => {
        let v = row[col.key];
        if (col.type === 'image') {
            return v
                ? <img src={`/${v}`} alt="" className="h-10 w-10 rounded-lg border border-ink-100 bg-white object-contain" />
                : <span className="flex h-10 w-10 items-center justify-center rounded-lg bg-ink-50 text-[9px] font-bold uppercase text-ink-300">none</span>;
        }
        if (col.truncate && typeof v === 'string' && v.length > col.truncate) v = `${v.slice(0, col.truncate)}…`;
        if (col.type === 'bool') return v ? <span className="font-semibold text-brand-700">Yes</span> : <span className="text-ink-400">—</span>;
        if (v == null || v === '') return <span className="text-ink-300">—</span>;
        return String(v);
    };

    return (
        <div>
            <div className="mb-5 flex flex-wrap items-center gap-3">
                <form onSubmit={(e) => { e.preventDefault(); applyFilters(); }} className="relative flex-1 sm:max-w-xs">
                    <Search size={15} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-400" aria-hidden />
                    <input value={q} onChange={(e) => setQ(e.target.value)} placeholder={searchPlaceholder}
                           className="w-full rounded-lg border border-ink-200 bg-white py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" />
                </form>
                {statusFilter}
                {createHref && (
                    <Link href={createHref}
                          className="ml-auto inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-bold text-white hover:bg-brand-800">
                        <Plus size={15} aria-hidden /> {createLabel || 'New'}
                    </Link>
                )}
            </div>

            <div className="overflow-x-auto rounded-xl border border-ink-200 bg-white">
                <table className="w-full text-left text-sm">
                    <thead>
                        <tr className="border-b border-ink-100 bg-ink-50/60 text-xs font-bold uppercase tracking-wider text-ink-500">
                            {columns.map((c) => <th key={c.key} scope="col" className={`px-4 py-3 ${c.class || ''}`}>{c.label}</th>)}
                            <th scope="col" className="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-ink-100">
                        {rows.data.map((row) => renderRow(row, cell))}
                        {rows.data.length === 0 && (
                            <tr><td colSpan={columns.length + 1} className="px-4 py-10 text-center text-sm text-ink-400">
                                {filters.q ? `Nothing found for “${filters.q}”.` : `No ${title.toLowerCase()} yet.`}
                            </td></tr>
                        )}
                    </tbody>
                </table>
            </div>

            {rows.last_page > 1 && (
                <nav aria-label="Pagination" className="mt-4 flex items-center justify-between text-sm">
                    <p className="text-ink-500">Page {rows.current_page} of {rows.last_page} · {rows.total} total</p>
                    <div className="flex gap-1.5">
                        {rows.links.map((l, i) => (
                            <Link key={i} href={l.url || '#'} preserveScroll
                                  className={`rounded-lg px-3 py-1.5 text-xs font-bold ${l.active ? 'bg-brand-700 text-white' : 'border border-ink-200 text-ink-600 hover:bg-ink-50'} ${!l.url ? 'pointer-events-none opacity-40' : ''}`}
                                  dangerouslySetInnerHTML={{ __html: l.label }} />
                        ))}
                    </div>
                </nav>
            )}
        </div>
    );
}
