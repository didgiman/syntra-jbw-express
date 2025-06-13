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
    public $numberOfTickets = 1;

    #[Validate()]
    public $attendees = [];
    
    public Event $event;
    public $message = '';

    public $userIsAttending = false;

    public $buyingStarted = false;

    public function mount($eventId, $is_buying = 0)
    {
        $this->event = Event::findOrFail($eventId);

        $this->buyingStarted = $is_buying;

        if (Auth::check()) {
            // Check if user is already attending this event
            if ($this->event->attendees()->where('user_id', Auth::id())->exists()) {
                $this->userIsAttending = true;
            } else {
                // Add current user to attendees to be added
                // $this->attendees[] = Auth::user();
                $this->selectUser(Auth::user());
            }
        }
    }

    public function startBuying()
    {
        if (!Auth::check()) {
            // Store event ID in session to redirect back after login
            session(['redirect_to_event' => $this->event->id]);
            session(['is_buying' => true]);
            $this->redirect(route('login'));
            return;
        }

        $this->buyingStarted = true;
    }

    #[On('attend:userSelected')]
    public function selectUser(User $user)
    {

        // Check if the user is already attending this event
        if ($this->event->attendees()->where('user_id', $user->id)->exists()) {
            $this->message = "$user->name is already attending this event.";
            return;
        }

        // Check if user is already selected
        $userExists = collect($this->attendees)->contains(function ($attendee) use ($user) {
            return is_object($attendee) && isset($attendee->id) && $attendee->id === $user->id;
        });

        // Only add if not already in the list
        if (!$userExists) {
            $this->attendees[] = $user;
        } else {
            $this->message = 'User already added';
        }
    }

    protected function rules()
    {
        return [
            'attendees' => [
                'required',
                'array',
                'min:1',
                'max:10'
            ],
            'attendees.*.id' => [
                'required',
                'exists:users,id',
                'unique:attendees,user_id,NULL,id,event_id,' . $this->event->id
            ],
        ];
    }

    public function messages()
    {
        return [
            'attendees.required' => 'You must select at least 1 user',
            'attendees.*.required' => 'The attendee is required',
            'attendees.*.min' => 'Type in at least 2 characters to search',
            'attendees.*.id.exists' => 'This user is unknown',
            'attendees.*.unique' => 'This user is already attending this event',
        ];
    }

    public function removeAttendee($index)
    {
        unset($this->attendees[$index]);
        $this->attendees = array_values($this->attendees);
    }

    public function buy()
    {
        // $this->validate();

        foreach($this->attendees as $attendee) {
            $this->event->attendees()->create(['user_id' => $attendee->id]);
        }

        $this->message = "Tickets purchased";

        $this->userIsAttending = true;
    }

    public function render()
    {
        return view('livewire.buy-tickets');
    }
}
