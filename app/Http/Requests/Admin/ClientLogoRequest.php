<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientLogoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'image' => [
                $this->route('client') ? 'nullable' : 'required',
                'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            ],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
        ];
    }
}
