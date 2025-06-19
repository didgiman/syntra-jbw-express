<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignTickets extends Component
{
    public $event;
    public $tickets = [];

    public $nbrTickets = 0;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    #[On('tickets.purchased')]
    public function refreshEvent()
    {
        $this->event->refresh();
        // $this->tickets = $this->event->userTickets()->get();

        // dd($this->tickets);
    }

    // #[On('ticket-assigned')]
    // public function refreshTickets()
    // {
    //     // This will trigger a re-render with fresh data
    //     // $this->dispatch('$refresh');
    // }

    public function render()
    {
        $this->tickets = $this->event->userTickets()->get();

        $this->nbrTickets = count($this->tickets);

        return view('livewire.assign-tickets');
    }
}
