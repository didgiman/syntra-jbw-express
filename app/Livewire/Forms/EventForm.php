<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventForm extends Form
{
    use WithFileUploads;

    public ?Event $event;

    public $eventTypes;

    public $user_id;

    #[Validate]
    public $type_id = '';

    #[Validate]
    public $name = '';
    
    public $description = '';
    
    #[Validate]
    public $start_time = '';

    #[Validate]
    public $end_time = '';

    #[Validate]
    public $location = '';

    #[Validate]
    public $price = '';

    #[Validate]
    public $max_attendees = '';

    #[Validate]
    public $poster;

    public $image;

    public $executionmode = 'create'; // either create or update

    public function mount()
    {
        $this->user_id = Auth::user()->id;
        $this->eventTypes = Type::orderby('description')->get();
    }

    public function updated($name, $value) 
    {
        $this->validateOnly($name);
    }

    protected function rules()
    {
        return [
            'type_id' => [
                'required'
            ],
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'start_time' => [
                'required',
                'date',
                $this->isUpdating() ? '' : 'after:now'
            ],
            'end_time' => [
                'required',
                'date',
                'after:start_time'
            ],
            'location' => [
                'required',
                'min:3'
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'max_attendees' => [
                'int'
            ],
            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:1024'
            ]
        ];
    }

    private function isUpdating()
    {
        // return isset($this->event->id) && !empty($this->event->id);
        return $this->executionmode === 'update';
    }

    public function setEvent(Event $event)
    {
        $this->mount();

        $this->executionmode = 'update';

        $this->name = $event->name;
        $this->description = $event->description;

        // Format it for the datetime-local input
        $this->start_time = \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i');
        $this->end_time = \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i');

        $this->type_id = $event->type_id;
        $this->location = $event->location;
        $this->price = $event->price;
        $this->max_attendees = is_null($event->max_attendees) ? '' : $event->max_attendees;
        $this->image = $event->image;

        $this->event = $event;
    }

    public function store()
    {
        $this->validate();

        if ($this->poster) {
            $this->image = '/storage/' . $this->poster->storePublicly('posters', ['disk' => 'public']);
        }

        if ($this->max_attendees === '') {
            $this->max_attendees = null;
        }

        // exclude all NULL values
        $event = Event::create(array_filter($this->all(), fn ($value) => !is_null($value)));

        // $event->attendees()->create(['user_id' => $this->user_id]); // this is how you link a user to an event (create attendee)

        return $event;
    }

    public function update()
    {
        $this->validate();

        if ($this->poster) {
            $this->image = '/storage/' . $this->poster->storePublicly('posters', ['disk' => 'public']);
        }

        if ($this->max_attendees === '') {
            $this->max_attendees = null;
        }

        $this->event->update($this->only([
            'name', 'description', 'start_time', 'end_time', 'type_id', 'location', 'price', 'max_attendees', 'image'
        ]));

        return $this->event;
    }

    protected function messages()
    {
        return [
            'type_id.required' => 'Please select the type of event you want to create',
            'start_time.after' => 'The start time of the event must be in the future',
            'end_time.after' => 'The end time of the event must be after the start time',
        ];
    }
}
