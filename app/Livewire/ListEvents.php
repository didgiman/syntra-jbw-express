<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;


class ListEvents extends Component
{
    public $view = 'all';

    public function render()
    {

        $events = Event::orderBy('start_time')->with(['type', 'attendees'])->paginate(10);
        // ->paginate(10)

        return view('livewire.list-events', ['events' => $events]);
    }
}
