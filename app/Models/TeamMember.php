<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'slug', 'role', 'photo', 'bio', 'is_leadership', 'sort_order',
        'meta_title', 'meta_description'];

    protected $casts = ['is_leadership' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function initials(): string
    {
        return collect(preg_split('/\s+/', trim(preg_replace('/^(Mr\.|Ms\.|Dr\.)\s+/i', '', $this->name))))
            ->filter()->map(fn ($w) => $w[0])->take(2)->implode('');
    }
}
