<?php

namespace App\Observers;

use App\Mail\AttendeeCreatedMail;
use App\Models\Attendee;
use Illuminate\Support\Facades\Mail;

class AttendeeObserver
{
    /**
     * Handle the Attendee "created" event.
     */
    public function created(Attendee $attendee): void
    {
        Mail::queue(new AttendeeCreatedMail($attendee));
    }

    /**
     * Handle the Attendee "updated" event.
     */
    public function updated(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "deleted" event.
     */
    public function deleted(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "restored" event.
     */
    public function restored(Attendee $attendee): void
    {
        //
    }

    /**
     * Handle the Attendee "force deleted" event.
     */
    public function forceDeleted(Attendee $attendee): void
    {
        //
    }
}
