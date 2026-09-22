<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnquiryRequest;
use App\Models\Enquiry;
use App\Models\Product;
use App\Notifications\EnquiryReceived;
use App\Support\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function create(): Response
    {
        // ?product={slug-or-id} pre-selects a product in the enquiry form —
        // product detail CTAs deep-link here.
        $selected = request('product')
            ? Product::where('has_detail_page', true)
                ->where(fn ($q) => $q->where('slug', request('product'))
                    ->orWhere('id', request('product')))
                ->value('id')
            : null;

        return Inertia::render('Contact', [
            'seo' => Seo::make(
                'Contact Us — Pharmaceutical Export Enquiries',
                'Contact Nymak Pharma for pharmaceutical exports, product enquiries, distribution and partnership — offices in India, UK, Sierra Leone & Liberia.'
            )->override('contact')->breadcrumbs([
                ['Home', url('/')],
                ['Contact Us', url('/contact')],
            ])->toArray(),
            'offices' => config('nymak.offices'),
            'products' => Product::where('has_detail_page', true)
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn ($p) => ['id' => $p->id, 'name' => $p->name]),
            'selectedProduct' => $selected,
            'formStartedAt' => now()->timestamp,
            'honeypot' => config('nymak.enquiry.honeypot'),
        ]);
    }

    public function store(EnquiryRequest $request): RedirectResponse
    {
        // Honeypot/min-time gate: fake success, store nothing.
        if ($request->looksLikeSpam()) {
            return redirect()->route('contact')->with('success',
                'Thank you — your enquiry has been received. Our team will respond shortly.');
        }

        $enquiry = Enquiry::create([
            ...$request->safe()->except([config('nymak.enquiry.honeypot'), 'form_started_at', 'privacy']),
            'ip_address' => $request->ip(),
        ]);

        Notification::route('mail', config('nymak.enquiry.notify_to'))
            ->notify(new EnquiryReceived($enquiry));

        return redirect()->route('contact')->with('success',
            'Thank you — your enquiry has been received. Our exports team will get back to you shortly.');
    }
}
