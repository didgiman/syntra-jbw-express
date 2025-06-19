<?php

namespace App\Livewire;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignTicket extends Component
{
    public Attendee $attendee;
    public bool $isFirst = false;

    public $message = '';

    public $isAssigned = false;

    public function mount(Attendee $attendee, bool $isFirst = false)
    {
        $this->attendee = $attendee;
        $this->isFirst = $isFirst;
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