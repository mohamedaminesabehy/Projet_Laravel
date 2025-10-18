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
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_active'  => 'boolean',
    ];

    /**
     * Direct access to participation rows (with status, joined_at, etc.)
     */
    public function participations()
    {
        return $this->hasMany(\App\Models\Participation::class);
    }

    /**
     * Users who joined this event (via participations table)
     */
    public function participants()
{
    return $this->belongsToMany(User::class, 'participations')
        ->withTimestamps()
        ->withPivot(['joined_at', 'left_at', 'status', 'source', 'notes']);
}

    /**
     * Public URL for the stored image (or a placeholder)
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::url($this->image)                 // e.g. /storage/events/abc.jpg
            : asset('images/placeholders/event.svg');    // placeholder SVG image
    }
}
