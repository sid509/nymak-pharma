import { Link } from '@inertiajs/react';

/**
 * Responsive product specification table. On small screens it scrolls
 * horizontally inside its own container rather than breaking the page.
 */
export default function SpecTable({ products, mode = 'strength' }) {
    const headers = mode === 'specimen'
        ? ['Product Name', 'Specimen']
        : ['Product Name', 'Strength', 'Pack Size'];

    return (
        <div className="overflow-x-auto rounded-xl border border-ink-100" role="region" aria-label="Product list" tabIndex={0}>
            <table className="spec-table w-full min-w-[520px] text-sm">
                <thead>
                    <tr>
                        {headers.map((h) => <th key={h} scope="col">{h}</th>)}
                        <th scope="col" className="w-24"><span className="sr-only">Details</span></th>
                    </tr>
                </thead>
                <tbody>
                    {products.map((p, i) => (
                        <tr key={i} className="bg-white transition-colors hover:bg-brand-50/40">
                            <td className="font-semibold text-ink-900">
                                {p.url ? (
                                    <Link href={p.url} className="text-brand-800 underline-offset-2 hover:underline">{p.name}</Link>
                                ) : p.name}
                            </td>
                            {mode === 'specimen' ? (
                                <td className="text-ink-600">{p.specimen || '—'}</td>
                            ) : (
                                <>
                                    <td className="text-ink-600">{p.strength || '—'}</td>
                                    <td className="text-ink-600">{p.pack_size || '—'}</td>
                                </>
                            )}
                            <td className="text-right">
                                {p.url && (
                                    <Link href={p.url} className="text-xs font-semibold text-brand-700 hover:text-brand-800">
                                        View
                                    </Link>
                                )}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
