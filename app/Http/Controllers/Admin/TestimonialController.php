<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;

class TestimonialController extends CrudController
{
    protected function model(): string
    {
        return Testimonial::class;
    }

    protected function request(): string
    {
        return TestimonialRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'Testimonials', 'singular' => 'Testimonial', 'route' => 'testimonials', 'icon' => 'Quote'],
            'columns' => [
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'country', 'label' => 'Country'],
                ['key' => 'quote', 'label' => 'Quote', 'truncate' => 60],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['name', 'quote'],
            'fields' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ['name' => 'country', 'label' => 'Country', 'type' => 'text'],
                ['name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'required' => true, 'rows' => 4],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
            'translatable' => [
                ['name' => 'country', 'label' => 'Country', 'type' => 'text'],
                ['name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'rows' => 4],
            ],
        ];
    }
}
