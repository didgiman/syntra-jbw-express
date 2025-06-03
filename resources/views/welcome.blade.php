@extends('partials.header')
@section('title', 'EventR Home')

@section('content')
    <div x-data="{ open: false, selectedEvent: null }" class="container mx-auto py-12 px-4">
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Upcoming Events</h2>
            <ul>
            {{-- event list --}}
@forelse($upcomingEvents as $event)
    <li 
        class="mb-2 p-4 border rounded shadow cursor-pointer hover:bg-black text-white"
        @click="open = true; selectedEvent = {
        ...{{ $event->toJson() }},
        remaining_spots: {{ is_null($event->max_attendees) ? 0 : ($event->max_attendees - $event->attendees->count()) }}
    }"
    >
        <div class="font-bold">{{ $event->name }}</div>
        <div class="text-red-300 text-sm font-bold">
            Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
        </div>
        <div class="mt-2">
            @if(is_null($event->max_attendees))
                <span class="text-green-600 font-semibold">Unlimited spots</span>
            @else
                @php
                    $remainingSpots = $event->max_attendees - $event->attendees->count();
                @endphp
                @if($remainingSpots <= 0)
                    <span class="text-red-600 font-semibold">SOLD OUT</span>
                @else
                    <span class="text-green-600 font-semibold">{{ $remainingSpots }} spots left</span>
                @endif
            @endif
        </div>
    </li>
@empty
    <li>No upcoming events.</li>
@endforelse
            </ul>
        </section>

<!-- Modal -->
<div 
    x-show="open" 
    style="display: none;" 
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
>
    <div class="bg-black rounded-lg shadow-lg max-w-md w-full p-6 relative text-white">
        <button 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
            @click="open = false"
        >&times;</button>
        <template x-if="selectedEvent">
            <div>
                <!-- SOLD OUT badge in modal (top left) -->
                <template x-if="selectedEvent.available_spots == null || selectedEvent.available_spots == 'null'">
                    <span class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded font-bold text-xs">SOLD OUT</span>
                </template>

                <h3 class="text-xl font-bold mb-2" x-text="selectedEvent.name"></h3>
                <div class="text-red-300 text-bold mb-2" x-text="'Starts: ' + new Date(selectedEvent.start_time).toLocaleString()"></div>
                <div class="mb-4" x-text="selectedEvent.description"></div>
                <div class="mb-4" x-text="'Location: ' + (selectedEvent.location ?? 'TBA')"></div>

                <div class="mb-4">
                    <!-- Show SOLD OUT when remaining_spots is null -->
                    <template x-if="selectedEvent.remaining_spots === null">
                        <span class="text-red-400 font-semibold">SOLD OUT</span>
                    </template>
                    
                    <!-- Show Unlimited spots when max_attendees is null -->
                    <template x-if="selectedEvent.max_attendees === null">
                        <span class="text-green-400 font-semibold">Unlimited spots</span>
                    </template>
                    
                    <!-- Show remaining spots count when available -->
                    <template x-if="selectedEvent.remaining_spots > 0">
                        <span class="text-green-400 font-semibold" x-text="selectedEvent.remaining_spots + ' spots left'"></span>
                    </template>
                </div>

                <!-- Button logic follows the same pattern -->
                <template x-if="selectedEvent.remaining_spots === null">
                    <button 
                        class="w-full mt-6 bg-gray-400 text-white px-6 py-2 rounded shadow cursor-not-allowed"
                        disabled
                    >
                        SOLD OUT
                    </button>
                </template>
                <template x-if="selectedEvent.max_attendees === null || selectedEvent.remaining_spots > 0">
                    <button 
                        class="w-full mt-6 bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700"
                        @click="alert('You are attending ' + selectedEvent.name); open = false;"
                    >
                        Attend
                    </button>
                </template>
            </div>
        </template>
    </div>
</div>
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection