<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'product_category_id', 'market_id', 'name', 'slug', 'therapeutic_group',
        'strength', 'pack_size', 'specimen', 'description', 'image',
        'meta_title', 'meta_description', 'has_detail_page', 'sort_order', 'i18n',
    ];

    protected $translatable = [
        'name', 'description', 'therapeutic_group', 'meta_title', 'meta_description',
    ];

    protected $casts = ['has_detail_page' => 'boolean', 'i18n' => 'array'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }
}
