<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) $this->slug ?: $this->title),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:220', Rule::unique('posts', 'slug')->ignore($this->route('post'))],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:400'],
            'body' => ['nullable', 'string', 'max:60000'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:200'],
        ];
    }
}
