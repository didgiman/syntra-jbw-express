<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AssignTickets extends Component
{
    public $event;
    public $tickets = [];

    public $nbrTickets = 0;
    public $nbrTicketsAssignedToUser = 0;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    #[On('tickets.purchased')]
    public function refreshEvent()
    {
        $this->event->refresh();
    }

    // Restore this code if you want to refresh the tickets to assign whenever a ticket has been assigned. This will mean that the assigned ticket is removed from the list and no longer visible.
    // #[On('ticket-assigned')]
    // public function refreshTickets()
    // {
    //     // This will trigger a re-render with fresh data
    //     $this->dispatch('$refresh');
    // }

    public function render()
    {
        
        $this->tickets = $this->event->userTickets()->get();
        $this->nbrTicketsAssignedToUser = $this->event->userTickets()->where('user_id', Auth::id())->count();

        $this->nbrTickets = count($this->tickets);

        return view('livewire.assign-tickets');
    }
}
