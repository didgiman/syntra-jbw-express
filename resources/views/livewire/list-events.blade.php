<div>
    {{-- Search Box --}}
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:items-center justify-end">
        <div class="flex gap-2 md:flex-1 justify-end items-center">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search events by name..." 
                class="px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 w-full lg:w-1/2 xl:1/3"
            >
            
            @if($search)
                <button 
                    wire:click="$set('search', '')" 
                    class="px-4 py-2 text-white rounded absolute cursor-pointer"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            @endif
        </div>
        <div class="flex justify-around md:flex-col items-start md:gap-1">
            <div><input type="checkbox" id="filter_free" wire:model.live="filter_free"><label for="filter_free" class="ml-2">Free events</label></div>
            <div><input type="checkbox" id="filter_now" wire:model.live="filter_now"><label for="filter_now" class="ml-2">Happening now</label></div>
        </div>
        <div>
            <select wire:model.live="filter_type" class="px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 w-full">
                <option value="">- Event Type -</option>
                @foreach ($eventTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->description }}</option>
                @endforeach
            </select>
        </div>
        @if ($filter_activated)
            <button 
                wire:click="resetFilters()" 
                class="btn btn-danger"
            >
                Reset
            </button>
        @endif
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
