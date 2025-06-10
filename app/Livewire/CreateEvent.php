<?php

namespace App\Livewire;

use App\Livewire\Forms\EventForm;
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

        $this->redirect(route('user.events.hosting'), navigate: true);
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
