<?php

namespace App\Livewire;

use App\Livewire\Forms\EventForm;
use Livewire\Component;
use App\Models\Event;
use Livewire\WithFileUploads;

class EditEvent extends Component
{
    use WithFileUploads;

    public EventForm $form;

    public function mount(Event $event)
    {
        $this->form->setEvent($event);
    }

    public function save()
    {
        $event = $this->form->update();

        session()->flash('message', 'Event "' . $event->name . '" updated successfully!');
        session()->flash('highlight-event', $event->id);

        $this->redirect(route('user.events.hosting'), navigate: true);
    }

    public function render()
    {
        return view('livewire.event-form');
            // ->layout('components.layouts.auth');
            // ->layout('welcome');
    }
}
