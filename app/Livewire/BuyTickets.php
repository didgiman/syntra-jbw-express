<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        $this->calculateTotalPrice();
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
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = number_format($this->event->price * $this->numberOfTickets, 2, '.', '');
    }

    public function buy()
    {

        DB::transaction(function() {
            try {
                // Reload the event with a "FOR UPDATE" lock to prevent race conditions
                $event = Event::where('id', $this->event->id)->lockForUpdate()->first();

                $currentCount = $event->attendees()->count();
                $max_attendees = $event->max_attendees;
                if (is_null($max_attendees)) {
                    // Unlimited spots available
                } else {
                    $availableSpots = $max_attendees - $currentCount;
                    if ($availableSpots < $this->numberOfTickets) {
                        $this->addError('numberOfTickets', 'Not enough tickets available.');
                        return;
                    }
                }

                // Purchase the tickets
                $attendees = [];
                $userId = Auth::id();
                for ($i = 0; $i < $this->numberOfTickets; $i++) {
                    $attendees[] = ['user_id' => $userId];
                }
                $event->attendees()->createMany($attendees);

                $this->message = "Tickets purchased";
                $this->ticketsPurchased = true;

                // Reset state
                $this->numberOfTickets = 1;
                $this->calculateTotalPrice();

                $this->dispatch('tickets.purchased');

            } catch (Throwable $e) {
                $this->message = "Unable to purchase tickets. Please try again. { $e.message}";
            }
        });

    }

    public function render()
    {
        return view('livewire.buy-tickets');
    }
}
