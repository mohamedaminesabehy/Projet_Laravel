<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'event_id','user_id','joined_at','left_at','checked_in_at','status','source','notes'
    ];

    protected $casts = [
        'joined_at'     => 'datetime',
        'left_at'       => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    public function event() { return $this->belongsTo(Event::class); }
    public function user()  { return $this->belongsTo(User::class); }

    public function scopeActive($q)
    {
        return $q->whereNull('left_at')->whereIn('status', ['joined','checked_in']);
    }
}
