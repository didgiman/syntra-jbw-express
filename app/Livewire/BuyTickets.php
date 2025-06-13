<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 

class BuyTickets extends Component
{
    public Event $event;
    public $numberOfTickets = 1;
    public $totalPrice = 0;
    
    public $message = '';

    public $ticketsPurchased = false;

    public function mount($eventId)
    {
        $this->event = Event::findOrFail($eventId);

        // Calculate total price
        $this->updatedNumberOfTickets();
    }

    public function startBuying()
    {
        $this->ticketsPurchased = false;
        $this->message = '';
        
        if (!Auth::check()) {
            // Store event ID in session to redirect back after login
            session(['redirect_to_event' => $this->event->id]);
            $this->redirect(route('login'));
            return;
        }
    }

    public function updatedNumberOfTickets()
    {
        $this->totalPrice = number_format($this->event->price * $this->numberOfTickets, 2, '.', '');
    }

    public function buy()
    {
        for ($i = 0; $i < $this->numberOfTickets; $i++) {
            $this->event->attendees()->create(['user_id' => Auth::id()]);
        }

        $this->message = "Tickets purchased";
        $this->ticketsPurchased = true;

        // Reset the number of tickets
        $this->numberOfTickets = 1;
        // Re-calculate total price
        $this->updatedNumberOfTickets();
    }

    public function render()
    {
        return view('livewire.buy-tickets');
    }
}
