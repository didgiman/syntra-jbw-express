<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'user_id'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function attendee(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    // check for available_spots
    public function attendees(): HasMany
{
    return $this->hasMany(Attendee::class);
}

// Accessor for available_spots
public function getAvailableSpotsAttribute()
{
    // to the DB
    return $this->max_attendees - $this->attendees()->count();
}
}
