<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventList extends Component
{
    public function render()
    {
        $events = Event::orderBy('start_time')->paginate(5);
        return view('livewire.event-list',['events' => $events]);
    }
}
