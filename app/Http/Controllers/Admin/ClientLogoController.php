<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ClientLogoRequest;
use App\Models\ClientLogo;

class ClientLogoController extends CrudController
{
    protected function model(): string
    {
        return ClientLogo::class;
    }

    protected function request(): string
    {
        return ClientLogoRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'Client Logos', 'singular' => 'Client logo', 'route' => 'clients', 'icon' => 'BadgeCheck'],
            'columns' => [
                ['key' => 'image', 'label' => '', 'type' => 'image', 'class' => 'w-14'],
                ['key' => 'name', 'label' => 'Client'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['name'],
            'fields' => [
                ['name' => 'name', 'label' => 'Client name', 'type' => 'text', 'required' => true,
                    'help' => 'Used as the alt text — not shown on the page.'],
                ['name' => 'image', 'label' => 'Logo', 'type' => 'image', 'dir' => 'clients', 'required' => true],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
        ];
    }
}
