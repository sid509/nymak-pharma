<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class JourneyItem extends Model
{
    use HasTranslations;

    protected $fillable = [
        'year', 'title', 'body', 'icon', 'image', 'image_2', 'fit', 'sort_order', 'i18n',
    ];

    protected $translatable = [
        'title', 'body',
    ];

    protected $casts = [
        'i18n' => 'array',
    ];
}
