<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Market extends Model
{
    protected $fillable = [
        'name', 'slug', 'iso_code', 'region', 'description', 'show_in_portfolio', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected $casts = ['show_in_portfolio' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }
}
