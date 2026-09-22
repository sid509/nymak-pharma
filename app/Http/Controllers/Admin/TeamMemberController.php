<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\TeamMember;

class TeamMemberController extends CrudController
{
    protected function model(): string
    {
        return TeamMember::class;
    }

    protected function request(): string
    {
        return TeamMemberRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'Team Members', 'singular' => 'Team member', 'route' => 'team-members', 'icon' => 'Users'],
            'columns' => [
                ['key' => 'photo', 'label' => '', 'type' => 'image', 'class' => 'w-14'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'role', 'label' => 'Role'],
                ['key' => 'is_leadership', 'label' => 'Leadership', 'type' => 'bool'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['name', 'role'],
            'fields' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'URL slug', 'type' => 'text',
                    'help' => 'Auto-generated from name if blank — drives /team/{slug}.'],
                ['name' => 'role', 'label' => 'Role / title', 'type' => 'text', 'required' => true],
                ['name' => 'photo', 'label' => 'Photo', 'type' => 'image', 'dir' => 'team',
                    'help' => 'Optional — initials shown when empty.'],
                ['name' => 'bio', 'label' => 'Bio (detail page body)', 'type' => 'textarea', 'rows' => 6,
                    'help' => 'Public profile page exists only when a bio is set.'],
                ['name' => 'is_leadership', 'label' => 'Show in leadership section', 'type' => 'checkbox'],
                ['name' => 'meta_title', 'label' => 'Meta title', 'type' => 'text',
                    'help' => 'Blank derives from name + role.'],
                ['name' => 'meta_description', 'label' => 'Meta description', 'type' => 'textarea', 'rows' => 2],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
        ];
    }
}
