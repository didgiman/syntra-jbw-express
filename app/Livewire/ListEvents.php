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

    public $eventTypes;

    public function mount()
    {
        $this->eventTypes = Type::orderby('description')->get();
    }
    
    public function updating($property, $value)
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Event::query();
        
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter_free) {
            $query->where('price', 0);
        }

        if ($this->filter_type) {
            $query->where('type_id', $this->filter_type);
        }

        if ($this->filter_now) {
            $query->where('start_time', '<', now());
        }
        
        $events = $query->orderBy('start_time')
                       ->with(['type', 'attendees'])
                       ->paginate(10);

        return view('livewire.list-events', [
            'events' => $events,
        ]);
    }
}
