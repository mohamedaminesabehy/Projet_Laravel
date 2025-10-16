<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
public function getImageUrlAttribute(): string
    {
        // Returns something like "/storage/events/abc123.jpg"
        return $this->image ? Storage::url($this->image) : asset('images/placeholders/event.jpg');
    }
}
