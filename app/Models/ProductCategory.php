<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use App\Support\Html;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name', 'slug', 'icon', 'intro', 'description', 'content', 'image',
        'meta_title', 'meta_description', 'sort_order', 'i18n',
    ];

    protected $translatable = [
        'name', 'intro', 'description', 'content', 'meta_title', 'meta_description',
    ];

    protected $casts = ['i18n' => 'array'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    public function featuredProducts(): HasMany
    {
        return $this->products()->where('has_detail_page', true);
    }

    /** WYSIWYG HTML is sanitised on write so it is always safe to render raw. */
    protected function content(): Attribute
    {
        return Attribute::make(set: fn (?string $value) => Html::sanitize($value));
    }
}
