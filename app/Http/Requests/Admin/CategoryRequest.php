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
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['integer', 'min:0', 'max:255'],
        ];
    }
}
