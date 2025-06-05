<?php

namespace App\Models;

use App\Models\Scopes\UpcomingEventScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected static function booted()
    {
        // By default, the model will only return Events for which the end_time is not in the past
        static::addGlobalScope(new UpcomingEventScope);
    }

    // Various scopes defined
    // See UserEventController for real examples on how to use
    public function scopePast($query)
    {
        return $query->withoutGlobalScope(UpcomingEventScope::class)
                    ->where('end_time', '<', now());

        // Use like this:
        // $pastEvents = Event::past()->get();
    }
    public function scopeAllEvents($query)
    {
        // Includes past and upcoming events

        return $query->withoutGlobalScope(UpcomingEventScope::class);

        // Use like this:
        // $pastEvents = Event::allEvents()->get();
    }
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('user_id', $userId);

        // use like this:
        // $hosting = Event::createdBy($userId)
    }

    public function scopeAttendedBy($query, $userId)
    {
        return $query->whereHas('attendees', fn($q) => $q->where('user_id', $userId));

        // use like this:
        // $attending = Event::attendedBy($userId)
    }

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

    protected $appends = ['available_spots'];

    protected $rules = [
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // attendees relationshipp
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
