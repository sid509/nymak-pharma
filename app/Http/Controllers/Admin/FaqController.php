<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;

class FaqController extends CrudController
{
    protected function model(): string
    {
        return Faq::class;
    }

    protected function request(): string
    {
        return FaqRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'FAQs', 'singular' => 'FAQ', 'route' => 'faqs', 'icon' => 'CircleHelp'],
            'columns' => [
                ['key' => 'question', 'label' => 'Question'],
                ['key' => 'category', 'label' => 'Category'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['question', 'answer'],
            'fields' => [
                ['name' => 'question', 'label' => 'Question', 'type' => 'text', 'required' => true],
                ['name' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'required' => true, 'rows' => 4],
                ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'help' => 'e.g. General, Products, Certifications, Orders'],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
        ];
    }
}
