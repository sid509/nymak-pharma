<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['is_leadership' => $this->boolean('is_leadership')]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'role' => ['required', 'string', 'max:120'],
            'is_leadership' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
        ];
    }
}
