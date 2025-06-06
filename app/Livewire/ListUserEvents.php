<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListUserEvents extends Component
{
    use AuthorizesRequests;

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

    public function render()
    {

        $userId = Auth::id();

        $events = match ($this->view) {
            'hosting' => Event::createdBy($userId)->with('type')->orderBy('start_time')->get(),
            'hosting.past' => Event::createdBy($userId)->past()->with('type')->latest('start_time')->get(),
            'attending' => Event::attendedBy($userId)->with('type')->orderBy('start_time')->get(),
            'attending.past' => Event::attendedBy($userId)->past()->with('type')->latest('start_time')->get(),
            default => collect(),
        };

        return view('livewire.list-user-events', ['events' => $events]);
    }
}
