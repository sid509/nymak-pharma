<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:80'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:4000'],
            'product_id' => ['nullable', 'exists:products,id'],
            'privacy' => ['accepted'],
            // Anti-spam honeypot — bots that fill it are caught by
            // looksLikeSpam(), which returns a fake success response.
            config('nymak.enquiry.honeypot') => ['nullable', 'string', 'max:190'],
            'form_started_at' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'privacy.accepted' => 'Please agree to the privacy policy before submitting.',
            'message.min' => 'Please include a few more details about your enquiry.',
        ];
    }

    /** Silently discard obvious bot submissions without tipping them off. */
    public function looksLikeSpam(): bool
    {
        if ($this->filled(config('nymak.enquiry.honeypot'))) {
            return true;
        }

        $started = (int) $this->input('form_started_at', 0);
        $elapsed = now()->timestamp - $started;

        // Negative elapsed means the client clock runs ahead of the server —
        // clock skew is not a spam signal, so only flag positive short gaps.
        return $started > 0 && $elapsed >= 0 && $elapsed < (int) config('nymak.enquiry.min_seconds', 3);
    }
}
