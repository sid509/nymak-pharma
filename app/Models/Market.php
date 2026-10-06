<?php

namespace App\Models;

use App\Support\Html;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Market extends Model
{
    protected $fillable = [
        'name', 'slug', 'iso_code', 'region', 'description', 'content', 'latitude', 'longitude',
        'show_in_portfolio', 'sort_order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'show_in_portfolio' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    /** WYSIWYG HTML is sanitised on write so it is always safe to render raw. */
    protected function content(): Attribute
    {
        return Attribute::make(set: fn (?string $value) => Html::sanitize($value));
    }
}
