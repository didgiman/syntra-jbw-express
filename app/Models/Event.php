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
        'user_id',
        'type_id',
        'location',
        'price',
        'max_attendees',
        'image',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    // include the available_spots attribute in the JSON 
    // when calling @click="open = true; selectedEvent = {{ $event->toJson() }}"
    protected $appends = ['available_spots'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    // Accessor for available_spots
    public function getAvailableSpotsAttribute()
    {
        // If max_attendees is null, return 0 (unlimited spots)
        if (is_null($this->max_attendees)) {
            return 0;
        }
 
        // Calculate remaining spots
        $taken = $this->attendees()->count();
        $remaining = $this->max_attendees - $taken;
 
        // If no spots left, return null (sold out)
        if ($remaining <= 0 && $this->max_attendees !== 0) {
            return null;
        }
 
        // If max_attendees is 0 or there are spots left, return the count
        return $this->max_attendees === 0 ? 0 : $remaining;
    }
}
