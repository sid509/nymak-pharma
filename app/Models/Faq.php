<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = ['question', 'answer', 'category', 'sort_order', 'i18n'];

    protected $translatable = ['question', 'answer', 'category'];

    protected $casts = ['i18n' => 'array'];
}
