<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateEvent extends Component
{

    public $user_id;

    #[Validate('required')]
    public $name = '';

    public $description = '';

    #[Validate('required|date|after:now')]
    public $start_time = '';

    #[Validate('required|date|after:start_time')]
    public $end_time = '';

    // #[Validate('required|datetime')]
    // public $location = '';

    // #[Validate('required|number')]
    // public $price = '';

    // #[Validate('required|int')]
    // public $max_attendees = '';

    // public $poster = '';

    public function save()
    {
        $this->validate();

        Event::create($this->all());

        $this->redirect(route('user.events'), navigate: true);
    }

    public function mount()
    {
        $this->user_id = Auth::user()->id;
    }

    public function render()
    {
        return view('livewire.create-event');
    }

    public function messages()
    {
        return [
            'start_time.after' => 'The start time of the event must be in the future',
            'end_time.after' => 'The end time of the event must be after the start time',
        ];
    }
}
