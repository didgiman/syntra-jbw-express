<?php

namespace App\Livewire;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignTicket extends Component
{
    public Attendee $attendee;
    public bool $isFirst = false;
    public int $index;

    public $message = '';

    public $isAssigned = false;

    public function mount(Attendee $attendee, int $index)
    {
        $this->attendee = $attendee;
        $this->index = $index;
        $this->isFirst = $index == 0;

        $this->isAssigned = $this->isFirst || $attendee->user_id !== Auth::id();
    }

    public function changeAssignee()
    {
        $this->isAssigned = false;
        $this->message = '';
    }

    public function getListeners()
    {
        return [
            "ticket-user-selected.{$this->attendee->id}" => 'assign',
        ];
    }

    public function assign(User $user)
    {
        if (!$user) {
            $this->addError('user', 'No user selected.');
            return;
        }

        // Check if there are attendees for the same event with the same user_id
        $event = $this->attendee->event;
        $existingAttendee = Attendee::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->where('id', '!=', $this->attendee->id) // Exclude current attendee
            ->first();

        if ($existingAttendee) {
            $this->addError('user', $existingAttendee->user->name . " already has a ticket for this event.");
            return;
        }

        $this->attendee->update([
            'user_id' => $user->id
        ]);
        $this->message = "Ticket assigned succesfully to {$user->name}.";

        $this->isAssigned = true;

        $this->dispatch('ticket-assigned', attendee: $this->attendee);
    }

    public function render()
    {
        return view('livewire.assign-ticket');
    }
}
// 