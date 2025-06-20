<?php

namespace App\Models;

use App\Mail\EventStartingSoonMail;
use App\Models\Scopes\UpcomingEventScope;
use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

#[ObservedBy([EventObserver::class])]
class Event extends Model
{
    use HasFactory, SoftDeletes;

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

        // This query scope will retrieve all events that the given user attends
        // and includes the attendee id in the result set

        return $query
            ->join('attendees', 'events.id', '=', 'attendees.event_id')
            ->where('attendees.user_id', $userId)
            ->select('events.*', DB::raw('MIN(attendees.id) as attendee_id')) // This will take only the first attendee id for a given user_id + event_id combination, to avoid duplicates
            ->groupBy('events.id');

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

    public function currentUserAttendee(): HasOne
    {
        return $this->hasOne(Attendee::class)
                    ->where('user_id', Auth::id());
    }

    public function userTickets()
    {
        return $this->hasMany(Attendee::class)
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                  ->orWhere('purchased_by', Auth::id());
            });
    }

    // Use withCount for efficient counting when querying
    // Example: Event::withCount('userTickets')->get()
    public function countUserTickets()
    {
        return $this->userTickets()->count();
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

    public function sendStartingNotification()
    {
        // Reduce attendees to unique list of users (1 user can have multiple attendees for the same event)
        $attendeeIds = $this->attendees()->selectRaw('MIN(id) as id')->groupBy('user_id')->pluck('id');

        $attendees = Attendee::whereIn('id', $attendeeIds)->get();

        foreach ($attendees as $attendee) {
            Mail::queue(new EventStartingSoonMail($this, $attendee));
        }
    }
}
