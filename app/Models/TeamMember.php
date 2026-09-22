<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'role', 'is_leadership', 'sort_order'];

    protected $casts = ['is_leadership' => 'boolean'];
}
