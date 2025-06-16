<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;

class ListUserEvents extends Component
{
    use AuthorizesRequests, WithPagination;

    public $view = '';

    public $message;

    public function mount(string $view)
    {
        $this->view = $view;
    }

    public function delete(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        $this->message = 'Event deleted successfully.';
    }

    public function attend(Event $event)
    {
        // Check if user is already attending this event
        if ($event->attendees()->where('user_id', Auth::id())->exists()) {
            $this->message = '<span class="text-red-500">You are already attending this event.</span>';
            return;
        }

        $event->attendees()->create(['user_id' => Auth::id()]);
        $this->message = 'You are now attending this event.';
    }

    public function unattend(Event $event)
    {
        $event->attendees()->where('user_id', Auth::id())->delete();
        $this->message = 'You are no longer attending this event.';
    }

    public function downloadTicket(Event $event)
    {  
        $url = route('tickets.download', [$event->id, Auth::id()]);

        // Trigger full browser download
        $this->dispatch('download-ticket', url: $url);
    }

    public function render()
    {

        $userId = Auth::id();

        $events = match ($this->view) {
            'hosting' => Event::createdBy($userId)->with(['type', 'attendees'])->orderBy('start_time')->paginate(10),
            'hosting.past' => Event::createdBy($userId)->past()->with(['type', 'attendees'])->latest('start_time')->paginate(10),
            'attending' => Event::attendedBy($userId)->with('type')->orderBy('start_time')->paginate(10),
            'attending.past' => Event::attendedBy($userId)->past()->with('type')->latest('start_time')->paginate(10),
            default => collect(),
        };

        return view('livewire.list-user-events', ['events' => $events]);
    }
}
