<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'image',
        'is_active'
    ];
    public function participants()
{
    return $this->belongsToMany(\App\Models\User::class, 'event_user');
}
}
