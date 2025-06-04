@extends('partials.header')
@section('title', 'EventR Home')

@section('content')
    <div x-data="{ 
        open: false, 
        selectedEvent: null,
        calculateTimeLeft(startTime) {
            const now = new Date().getTime();
            const eventTime = new Date(startTime).getTime();
            const difference = eventTime - now;
            
            if (difference < 0) {
                return 'Event has started';
            }
            
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);
            
            return `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }
    }" class="container mx-auto py-12 px-4">
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
    {{-- displaying the event image --}}
        <div class="flex gap-4 items-start">
            @if($event->image)
                <img 
                    src="{{ asset('storage/' . $event->image) }}" 
                    alt="{{ $event->name }} poster" 
                    class="w-32 h-32 object-cover rounded-lg"
                >
            @endif
            <div class="flex-1">
                <div class="font-bold">{{ $event->name }}</div>
                <div class="text-red-300 text-sm font-bold">
                    Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                </div>

{{-- Countdown till event --}}
                    <div class="text-yellow-300 text-sm mt-1"
                         x-data
                         x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft('{{ $event->start_time }}'), 1000)">
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
            </div>
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
    class="fixed inset-0 flex items-center justify-center"
    {{-- closing the modal window with esc --}}
    @keydown.escape.window="open = false"
>
    <!-- Backdrop with click handler-->
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" 
    @click="open = false"></div>
    
    <!-- Modal Content -->
    <div class="bg-black rounded-lg shadow-lg max-w-2xl w-full p-6 relative text-white z-10">
        <button 
            class="absolute top-2 right-2 text-gray-400 hover:text-white text-lg flex items-center gap-2"
            @click="open = false"
        >
            <span class="text-sm font-medium">Close</span>
            <span class="text-2xl">&times;</span>
        </button>
        <template x-if="selectedEvent">
            <div>
                <!-- SOLD OUT badge in modal (top left) -->
                <template x-if="selectedEvent.available_spots == null || selectedEvent.available_spots == 'null'">
                    <span class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded font-bold text-xs">SOLD OUT</span>
                </template>

                <h3 class="text-xl font-bold mb-2" x-text="selectedEvent.name"></h3>
                <div class="text-red-300 text-bold mb-2" x-text="'Starts: ' + new Date(selectedEvent.start_time).toLocaleString()"></div>
                
 <!-- image template -->
        <template x-if="selectedEvent.image">
            <img 
                :src="'/storage/' + selectedEvent.image" 
                :alt="selectedEvent.name + ' poster'"
                class="w-full max-h-[400px] object-contain rounded-lg mb-4"
            >
        </template>

        <div class="text-red-300 text-bold mb-2" x-text="'Starts: ' + new Date(selectedEvent.start_time).toLocaleString()"></div>

                <!-- Countdown in modal -->
                <div class="text-yellow-300 text-sm mb-2"
                     x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft(selectedEvent.start_time), 1000)">
                </div>
                
                <div class="mb-4" x-text="selectedEvent.description"></div>
                <div class="mb-4" x-text="'Location: ' + (selectedEvent.location ?? 'TBA')"></div>

                <div class="mb-4">
                    <!-- Availability status -->
                    <template x-if="selectedEvent.remaining_spots === null">
                        <span class="text-red-400 font-semibold">SOLD OUT</span>
                    </template>
                    <template x-if="selectedEvent.max_attendees === null">
                        <span class="text-green-400 font-semibold">Unlimited spots</span>
                    </template>
                    <template x-if="selectedEvent.remaining_spots > 0">
                        <span class="text-green-400 font-semibold" x-text="selectedEvent.remaining_spots + ' spots left'"></span>
                    </template>
                </div>

                <!-- Buttons -->
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