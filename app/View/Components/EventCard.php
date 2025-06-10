<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EventCard extends Component
{
    public $event;
    public $view;

    public function __construct($event, $view)
    {
        $this->event = $event;
        $this->view = $view;
    }

    public function render()
    {
        return view('components.event-card');
    }
}
