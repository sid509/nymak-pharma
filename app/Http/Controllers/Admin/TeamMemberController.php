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
                ['name' => 'role', 'label' => 'Role / title', 'type' => 'text', 'required' => true],
                ['name' => 'photo', 'label' => 'Photo', 'type' => 'image', 'dir' => 'team',
                    'help' => 'Optional — initials shown when empty.'],
                ['name' => 'is_leadership', 'label' => 'Show in leadership section', 'type' => 'checkbox'],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
        ];
    }
}
