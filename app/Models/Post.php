<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'body', 'cover_image',
        'meta_title', 'meta_description', 'published_at', 'i18n',
    ];

    protected $translatable = [
        'title', 'category', 'excerpt', 'body', 'meta_title', 'meta_description',
    ];

    protected $casts = ['published_at' => 'datetime', 'i18n' => 'array'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
