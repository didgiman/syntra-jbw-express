<?php

namespace App\Models;

use App\Observers\AttendeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([AttendeeObserver::class])]
class Attendee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event_id', 'token', 'status'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function purchased_by()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }
}
