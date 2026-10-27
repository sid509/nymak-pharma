<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\JourneyItemRequest;
use App\Models\JourneyItem;

class JourneyItemController extends CrudController
{
    protected function model(): string
    {
        return JourneyItem::class;
    }

    protected function request(): string
    {
        return JourneyItemRequest::class;
    }

    protected function config(): array
    {
        return [
            'module' => ['title' => 'Journey timeline', 'singular' => 'Timeline entry', 'route' => 'journey'],
            'columns' => [
                ['key' => 'image', 'label' => '', 'type' => 'image', 'class' => 'w-14'],
                ['key' => 'year', 'label' => 'Year', 'class' => 'w-20'],
                ['key' => 'title', 'label' => 'Title'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-16'],
            ],
            'searchable' => ['year', 'title', 'body'],
            'fields' => [
                ['name' => 'year', 'label' => 'Year', 'type' => 'text', 'required' => true,
                    'help' => 'Shown on the arrow bar, e.g. 1998. Entries sharing a year sit under one marker.'],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'body', 'label' => 'Caption', 'type' => 'textarea', 'rows' => 3,
                    'help' => 'One or two short sentences under the title.'],
                ['name' => 'icon', 'label' => 'Icon', 'type' => 'text',
                    'help' => 'Font Awesome name (e.g. faAward). Shown on the card when no image is set.'],
                ['name' => 'image', 'label' => 'Image', 'type' => 'image', 'dir' => 'journey',
                    'help' => 'Card photo. Landscape images sit best.'],
                ['name' => 'image_2', 'label' => 'Second image', 'type' => 'image', 'dir' => 'journey',
                    'help' => 'Optional - renders side by side with the first, like the 1998 founding shots.'],
                ['name' => 'fit', 'label' => 'Image fit', 'type' => 'select',
                    'options' => [
                        ['value' => 'cover', 'label' => 'Fill frame (photos)'],
                        ['value' => 'contain', 'label' => 'Fit inside frame (logos, certificates, flags)'],
                    ],
                    'help' => 'Choose "Fit inside" for certificates, logos and flags so nothing gets cropped.'],
                ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number'],
            ],
            'translatable' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
                ['name' => 'body', 'label' => 'Caption', 'type' => 'textarea', 'rows' => 3],
            ],
        ];
    }
}
