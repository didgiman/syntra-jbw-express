<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;


class EventList extends Component
{
    public $view = 'all';

    public function render()
    {

        $events = Event::orderBy('start_time')->with(['type', 'attendees'])->paginate(10);
        // ->paginate(10)

        return view('livewire.event-list', ['events' => $events]);
    }
}
