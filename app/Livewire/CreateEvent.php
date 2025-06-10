<?php

namespace App\Livewire;

use App\Livewire\Forms\EventForm;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEvent extends Component
{
    use WithFileUploads;

    public EventForm $form;

    public function save()
    {
        $event = $this->form->store();

        session()->flash('message', 'Event "' . $event->name . '" created successfully!');
        session()->flash('highlight-event', $event->id);

        $perPage = 10; // or whatever your pagination size is

        $count = Event::createdBy($this->form->user_id)->where('start_time', '<=', $event->start_time)->count();

        $page = max(1, (int) ceil($count / $perPage));

        return redirect()->route('user.events.hosting', ['page' => $page]);
    }

    public function mount()
    {
        $this->form->mount();
    }

    public function render()
    {
        return view('livewire.event-form');
    }
}
