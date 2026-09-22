import { router } from '@inertiajs/react';
import { TriangleAlert } from 'lucide-react';
import { useState } from 'react';

/**
 * Delete button + confirmation modal. Posts a DELETE via Inertia.
 */
export default function ConfirmDelete({ href, name = 'this record', onError = null }) {
    const [open, setOpen] = useState(false);
    const [busy, setBusy] = useState(false);
    const [error, setError] = useState(null);

    const remove = () => {
        setBusy(true);
        router.delete(href, {
            onFinish: () => setBusy(false),
            onSuccess: () => setOpen(false),
            onError: (errors) => {
                setError(Object.values(errors)[0] || 'Delete failed — the record may be in use.');
                onError?.(errors);
            },
        });
    };

    return (
        <>
            <button type="button" onClick={() => { setError(null); setOpen(true); }}
                    className="text-xs font-bold text-red-600 hover:underline">
                Delete
            </button>
            {open && (
                <div role="dialog" aria-modal="true" aria-label="Confirm deletion"
                     className="fixed inset-0 z-[60] flex items-center justify-center bg-ink-950/50 p-4"
                     onClick={() => setOpen(false)}>
                    <div className="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl" onClick={(e) => e.stopPropagation()}>
                        <div className="flex items-start gap-3">
                            <span className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                                <TriangleAlert size={18} aria-hidden />
                            </span>
                            <div>
                                <h2 className="text-base font-extrabold text-ink-900">Delete {name}?</h2>
                                <p className="mt-1 text-sm text-ink-500">This action cannot be undone.</p>
                                {error && <p className="mt-2 text-xs font-semibold text-red-600" role="alert">{error}</p>}
                            </div>
                        </div>
                        <div className="mt-5 flex justify-end gap-2.5">
                            <button type="button" onClick={() => setOpen(false)}
                                    className="rounded-lg border border-ink-200 px-4 py-2 text-sm font-bold text-ink-600 hover:bg-ink-50">
                                Cancel
                            </button>
                            <button type="button" onClick={remove} disabled={busy}
                                    className="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700 disabled:opacity-60">
                                {busy ? 'Deleting…' : 'Delete'}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
