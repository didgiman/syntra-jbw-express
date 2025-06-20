<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ListEvents extends Component
{
    use WithPagination;
    
    public $view = 'all';
    
    #[Url]
    public $search = '';
    #[Url]
    public $filter_free;
    #[Url]
    public $filter_now;
    #[Url]
    public $filter_type;

    public $filter_activated = false;

    public $eventTypes;

    public function mount()
    {
        $this->eventTypes = Type::orderby('description')->get();
    }
    
    public function updating($property, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->resetExcept('eventTypes');
    }
    
    public function render()
    {
        $query = Event::query();

        $this->filter_activated = false;
        
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
            $this->filter_activated = true;
        }

        if ($this->filter_free) {
            $query->where('price', 0);
            $this->filter_activated = true;
        }

        if ($this->filter_type) {
            $query->where('type_id', $this->filter_type);
            $this->filter_activated = true;
        }

        if ($this->filter_now) {
            $query->where('start_time', '<', now());
            $this->filter_activated = true;
        }
        
        $events = $query->orderBy('start_time')
                       ->with(['type', 'attendees'])
                       ->paginate(10);

        return view('livewire.list-events', [
            'events' => $events,
        ]);
    }
}
