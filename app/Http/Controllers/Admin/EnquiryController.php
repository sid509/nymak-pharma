<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EnquiryController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Enquiries/Index', [
            'enquiries' => Enquiry::query()
                ->with('product:id,name,slug')
                ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                    ->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('company', 'like', "%{$s}%")
                    ->orWhere('country', 'like', "%{$s}%")
                    ->orWhere('subject', 'like', "%{$s}%")))
                ->when($request->status === 'unread', fn ($q) => $q->unread())
                ->when($request->status === 'read', fn ($q) => $q->whereNotNull('read_at'))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
            'unreadCount' => Enquiry::unread()->count(),
            'filters' => $request->only('q', 'status'),
        ]);
    }

    public function markRead(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update(['read_at' => $enquiry->read_at ?? now()]);

        return back();
    }

    public function markUnread(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update(['read_at' => null]);

        return back();
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return back()->with('success', 'Enquiry deleted.');
    }
}
