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
}
