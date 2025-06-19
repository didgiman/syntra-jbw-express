<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class DisplayEvent extends Component
{
    public $eventId;
    public Event $event;
    public $view = 'details';
    public $message;

    public function mount($eventId)
    {
        $this->event = Event::with(['attendees', 'type'])->findOrFail($eventId);
    }

    #[On('ticket-assigned')]
    #[On('tickets.purchased')]
    public function refreshEvent()
    {
        // Refresh event
        $this->event = Event::with(['attendees', 'type'])->findOrFail($this->event->id);
    }

    public function attend(Event $event)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            // Store event ID in session to redirect back after login
            session(['redirect_to_event' => $event->id]);
            $this->redirect(route('login'));
            return;
        }
        
        // Check if user is already attending this event
        if ($event->attendees()->where('user_id', Auth::id())->exists()) {
            $this->message = '<span class="text-red-500">You are already attending this event.</span>';
            return;
        }

        $event->attendees()->create(['user_id' => Auth::id(), 'purchased_by' => Auth::id()]);
        $this->message = 'You are now attending this event.';
    }

    public function unattend(Event $event)
    {
        $event->attendees()->where('user_id', Auth::id())->delete();
        $this->message = 'You are no longer attending this event.';
    }

    public function downloadTicket()
    {
        
        $url = route('tickets.download', [$this->event->id, Auth::id()]);

        // Trigger full browser download
        $this->dispatch('download-ticket', url: $url);
    }

    public function render()
    {
        return view('livewire.display-event');
    }
}
