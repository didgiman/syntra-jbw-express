<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ListEvents extends Component
{
    use WithPagination;
    
    public $view = 'all';
    
    #[Url]
    public $search = '';
    
    public function updating($property, $value)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }
    
    public function render()
    {
        $query = Event::query();
        
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        $events = $query->orderBy('start_time')
                       ->with(['type', 'attendees'])
                       ->paginate(10);

        return view('livewire.list-events', [
            'events' => $events,
        ]);
    }
}
