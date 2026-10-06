<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'icon' => ['nullable', 'string', 'max:60'],
            'intro' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string', 'max:5000'],
            'content' => ['nullable', 'string', 'max:100000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['integer', 'min:0', 'max:255'],
            // French/Spanish translations — merged into the model's i18n JSON column.
            'i18n' => ['sometimes', 'array'],
            'i18n.*' => ['array'],
            'i18n.*.*' => ['nullable', 'string', 'max:100000'],
        ];
    }
}
