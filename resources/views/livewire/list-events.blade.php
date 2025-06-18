<div>
    {{-- Search Box --}}
    <div class="mb-6 flex gap-2">
        <div class="flex gap-2 flex-1">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search events by name..." 
                class="flex-1 px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 w-full"
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
        <div class="flex flex-col items-start gap-1">
            <div><input type="checkbox" id="filter_free" wire:model.live="filter_free"><label for="filter_free" class="ml-2">Free events</label></div>
            <div><input type="checkbox" id="filter_now" wire:model.live="filter_now"><label for="filter_now" class="ml-2">Happening now</label></div>
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
            <p class="text-gray-400">No events found matching your filter criteria</p>
        </div>
    @endif

    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>
