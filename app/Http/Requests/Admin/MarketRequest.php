<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MarketRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) $this->slug ?: $this->name),
            'iso_code' => strtoupper(trim((string) $this->iso_code)) ?: null,
            'latitude' => $this->latitude === '' ? null : $this->latitude,
            'longitude' => $this->longitude === '' ? null : $this->longitude,
            'show_in_portfolio' => $this->boolean('show_in_portfolio'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', Rule::unique('markets', 'slug')->ignore($this->route('market'))],
            'iso_code' => ['nullable', 'string', 'size:2', 'alpha'],
            'region' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:5000'],
            'content' => ['nullable', 'string', 'max:100000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:longitude'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:latitude'],
            'show_in_portfolio' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
            // French/Spanish translations — merged into the model's i18n JSON column.
            'i18n' => ['sometimes', 'array'],
            'i18n.*' => ['array'],
            'i18n.*.*' => ['nullable', 'string', 'max:100000'],
        ];
    }
}
