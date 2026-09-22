<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:80'],
            'quote' => ['required', 'string', 'max:1500'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
        ];
    }
}
