<?php

namespace App\Observers;

use App\Mail\EventUpdatedMail;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        // TO DO: Send a mail to the application admins
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        $attendees = $event->attendees()->with('user')->get();

        foreach ($attendees as $attendee) {
            Mail::queue(new EventUpdatedMail($event, $attendee));
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
