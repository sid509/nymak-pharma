<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_leadership' => $this->boolean('is_leadership'),
            'slug' => \Illuminate\Support\Str::slug((string) $this->slug
                ?: preg_replace('/^(Mr\.|Ms\.|Dr\.)\s+/i', '', (string) $this->name)),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140',
                \Illuminate\Validation\Rule::unique('team_members', 'slug')->ignore($this->route('team_member'))],
            'role' => ['required', 'string', 'max:120'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:10000'],
            'is_leadership' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
        ];
    }
}
