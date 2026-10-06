<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug(str_replace('/', '-', (string) $this->slug ?: $this->name)),
            'has_detail_page' => $this->boolean('has_detail_page'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:220', Rule::unique('products', 'slug')->ignore($this->route('product'))],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'market_id' => ['nullable', 'exists:markets,id'],
            'therapeutic_group' => ['nullable', 'string', 'max:120'],
            'strength' => ['nullable', 'string', 'max:120'],
            'pack_size' => ['nullable', 'string', 'max:120'],
            'specimen' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'has_detail_page' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
            // French/Spanish translations — merged into the model's i18n JSON column.
            'i18n' => ['sometimes', 'array'],
            'i18n.*' => ['array'],
            'i18n.*.*' => ['nullable', 'string', 'max:100000'],
        ];
    }
}
