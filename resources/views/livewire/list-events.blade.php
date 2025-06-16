<div>
    {{-- Search Box --}}
    <div class="mb-6">
        <div class="flex gap-2">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search events by name..." 
                class="flex-1 px-4 py-3 bg-gray-800 text-white rounded border border-gray-700"
            >
            
            @if($search)
                <button 
                    wire:click="$set('search', '')" 
                    class="px-4 py-2 bg-red-600 text-white rounded"
                >
                    Clear
                </button>
            @endif
        </div>
    </div>

    {{-- Events List --}}
    @if($events->count() > 0)
        @foreach ($events as $event)
            <x-event-card :event="$event" :view="$view">
                @slot('buttons')
                    <a href="{{ route('events.single', ['event' => $event->id]) }}" class="btn btn-primary">Details</a>
                @endslot
            </x-event-card>
        @endforeach
    @else
        <div class="bg-gray-800 p-6 rounded-lg text-center">
            <p class="text-gray-400">No events found matching "{{ $search }}"</p>
        </div>
    @endif

    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>
