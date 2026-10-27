<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JourneyItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'year' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:160'],
            'body' => ['nullable', 'string', 'max:2000'],
            'icon' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'fit' => ['nullable', 'string', 'in:cover,contain'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
            // French/Spanish translations - merged into the model's i18n JSON column.
            'i18n' => ['sometimes', 'array'],
            'i18n.*' => ['array'],
            'i18n.*.*' => ['nullable', 'string', 'max:100000'],
        ];
    }
}
