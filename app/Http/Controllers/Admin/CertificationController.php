<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CertificationRequest;
use App\Models\Certification;

class CertificationController extends CrudController
{
    protected function model(): string
    {
        return Certification::class;
    }

    protected function request(): string
    {
        return CertificationRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'Certifications', 'singular' => 'Certification', 'route' => 'certifications', 'icon' => 'BadgeCheck'],
            'columns' => [
                ['key' => 'image', 'label' => '', 'type' => 'image', 'class' => 'w-14'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'issuer', 'label' => 'Issuer'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['name', 'issuer'],
            'fields' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ['name' => 'issuer', 'label' => 'Issuer', 'type' => 'text'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                ['name' => 'image', 'label' => 'Logo / badge', 'type' => 'image', 'dir' => 'certifications',
                    'help' => 'Optional — shown on Quality and About pages.'],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
        ];
    }
}
