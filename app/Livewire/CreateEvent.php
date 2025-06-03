<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $eventTypes;

    public $user_id;

    #[Validate('required')]
    public $name = '';

    public $description = '';

    #[Validate('required|date|after:now')]
    public $start_time = '';

    #[Validate('required|date|after:start_time')]
    public $end_time = '';

    #[Validate('required')]
    public $type_id = '';

    #[Validate('required|min:3')]
    public $location = '';

    #[Validate('required|numeric')]
    public $price = '';

    #[Validate('int')]
    public $max_attendees = '';

    #[Validate('image|mimes:jpg,jpeg,png,gif|max:1024')]
    public $poster;

    public $image;

    public function mount()
    {
        $this->user_id = Auth::user()->id;
        $this->eventTypes = Type::orderby('description')->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->poster) {
            $this->image = $this->poster->storePublicly('posters', ['disk' => 'public']);
        }

        Event::create($this->all());

        $this->redirect(route('user.events'), navigate: true);
    }

    public function render()
    {
        return view('livewire.create-event');
    }

    public function messages()
    {
        return [
            'type_id.required' => 'Please select the type of event you want to create',
            'start_time.after' => 'The start time of the event must be in the future',
            'end_time.after' => 'The end time of the event must be after the start time',
        ];
    }
}
