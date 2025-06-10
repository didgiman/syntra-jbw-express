<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;


class EventList extends Component
{
    public $view = '';

    public function render()
    {

        $events = Event::orderBy('start_time')->paginate(10);
        // ->paginate(10)

        return view('livewire.event-list', ['events' => $events]);
    }
}
