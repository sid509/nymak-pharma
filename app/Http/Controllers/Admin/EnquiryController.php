<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EnquiryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Enquiries', [
            'seo' => ['title' => 'Enquiries', 'robots' => 'noindex, nofollow'],
            'enquiries' => Enquiry::with('product:id,name')
                ->latest()
                ->paginate(20)
                ->through(fn ($e) => [
                    'id' => $e->id,
                    'name' => $e->name,
                    'company' => $e->company,
                    'email' => $e->email,
                    'phone' => $e->phone,
                    'country' => $e->country,
                    'subject' => $e->subject,
                    'message' => $e->message,
                    'product' => $e->product?->name,
                    'read' => $e->read_at !== null,
                    'created_at' => $e->created_at->toIso8601String(),
                ]),
            'unread' => Enquiry::unread()->count(),
        ]);
    }

    public function markRead(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update(['read_at' => $enquiry->read_at ?? now()]);

        return back();
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return back();
    }
}
