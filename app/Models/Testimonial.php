<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'country', 'quote', 'sort_order', 'i18n'];

    protected $translatable = ['country', 'quote'];

    protected $casts = ['i18n' => 'array'];
}
