<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:300'],
            'answer' => ['required', 'string', 'max:3000'],
            'category' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
        ];
    }
}
