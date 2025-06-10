@extends('partials.header')
@section('title', 'EventR Home')

{{-- Load External Scripts --}}
@push('scripts')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endpush

@section('content')
    {{-- Main Container with Alpine.js State --}}
    <div x-data="{ 
        open: false,           {{-- Controls modal visibility --}}
        selectedEvent: null    {{-- Stores current event data --}}
    }" class="container mx-auto py-12 px-4">
        
        {{-- Events List Section --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Upcoming Events</h2>
            <ul>
                @forelse($upcomingEvents as $event)
                    {{-- Event Card --}}
                    <li 
                        class="mb-2 p-4 border rounded shadow cursor-pointer hover:bg-black text-white relative"
                        @click="open = true; selectedEvent = {
                            ...{{ $event->toJson() }},
                            type: {{ $event->type->toJson() }},
                            type_name: '{{ $event->type ? strtoupper($event->type->description) : 'NO TYPE' }}',
                            remaining_spots: {{ is_null($event->max_attendees) ? 0 : ($event->max_attendees - $event->attendees->count()) }}
                        }"
                    >
                        {{-- Event Type Badge --}}
                        <span class="text-xs bg-violet-500 text-white py-1 px-2 rounded absolute -top-2 shadow uppercase -left-2 md:-left-4">
                        {{ $event->type ? $event->type->description : 'NO TYPE' }}
                        </span>

                        <div class="flex gap-4 items-start">
                            {{-- Event Image --}}
                            @if($event->image)
                                <img 
                                    src="{{ $event->image }}" 
                                    alt="{{ $event->name }} poster" 
                                    class="w-32 h-32 object-cover rounded-lg"
                                    onerror="console.error('Failed to load image:', this.src)"
                                >
                            @endif

                            {{-- Event Details Container --}}
                            <div class="flex-1">
                                {{-- Event Name --}}
                                <div class="font-bold text-lg mb-2">{{ $event->name }}</div>
                                
                                {{-- Start Time --}}
                                <div class="text-red-300 text-sm font-bold mb-2">
                                    Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                </div>

                                {{-- Live Countdown --}}
                                <div class="text-yellow-300 text-sm mb-2"
                                     x-data
                                     x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft('{{ $event->start_time }}'), 1000)">
                                </div>

                                {{-- Availability Status --}}
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
                    <li class="text-gray-500 text-center py-4">No upcoming events.</li>
                @endforelse
            </ul>
        </section>

        {{-- Event Details Modal --}}
        <div 
            x-show="open" 
            style="display: none;" 
            class="fixed inset-0 overflow-hidden"
            @keydown.escape.window="open = false"
            x-init="$watch('open', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');    {{-- Prevent background scroll --}}
                } else {
                    document.body.classList.remove('overflow-hidden'); {{-- Restore background scroll --}}
                }
            })"
        >
            {{-- Modal Backdrop --}}
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" 
                @click="open = false">
            </div>
            
            {{-- Modal Container --}}
            <div class="fixed inset-0 flex items-center justify-center pointer-events-none">
                {{-- Modal Content --}}
                <div class="bg-black rounded-lg shadow-lg w-full max-w-2xl relative text-white z-10 max-h-[80vh] flex flex-col pointer-events-auto">
                    {{-- Sticky Header --}}
                    <div class="sticky top-0 bg-black z-20 p-6 border-b border-gray-800">
                        {{-- Close Button --}}
                        <button 
                            class="absolute top-6 right-6 text-gray-400 hover:text-white text-lg flex items-center gap-2"
                            @click="open = false"
                        >
                            <span class="text-sm font-medium">Close</span>
                            <span class="text-2xl">&times;</span>
                        </button>
                        {{-- Event Title --}}
                        <template x-if="selectedEvent">
                            <h3 class="text-xl font-bold pr-24" x-text="selectedEvent.name"></h3>
                        </template>
                    </div>

                    {{-- Scrollable Content Area --}}
                    <div class="p-6 overflow-y-auto">
                        <template x-if="selectedEvent">
                            <div>
                                {{-- Sold Out Badge --}}
                                <template x-if="selectedEvent.available_spots == null || selectedEvent.available_spots == 'null'">
                                    <span class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded font-bold text-xs">
                                        SOLD OUT
                                    </span>
                                </template>

                                {{-- Event Image --}}
                                <template x-if="selectedEvent.image">
                                    <img 
                                        :src="selectedEvent.image"
                                        :alt="selectedEvent.name + ' poster'"
                                        class="w-full max-h-[400px] object-contain rounded-lg mb-4"
                                    >
                                </template>

                                {{-- Event Details --}}
                                <div class="space-y-4">
                                    {{-- Start Time --}}
                                    <div class="text-red-300 text-bold" 
                                         x-text="'Starts: ' + new Date(selectedEvent.start_time).toLocaleString()">
                                    </div>

                                    {{-- Live Countdown --}}
                                    <div class="text-yellow-300 text-sm"
                                         x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft(selectedEvent.start_time), 1000)">
                                    </div>
                                    
                                    {{-- Description --}}
                                    <div x-text="selectedEvent.description"></div>

                                    {{-- Location with Google Maps Link --}}
                                    <div>
                                        <a 
                                            x-show="selectedEvent.location"
                                            :href="'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(selectedEvent.location)"
                                            class="text-blue-400 hover:text-blue-300 hover:underline"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            x-text="'Location: ' + selectedEvent.location"
                                        ></a>
                                        <span x-show="!selectedEvent.location" class="text-gray-400">
                                            Location: TBA
                                        </span>
                                    </div>

                                    {{-- Availability Status --}}
                                    <div>
                                        <template x-if="selectedEvent.remaining_spots === null">
                                            <span class="text-red-400 font-semibold">SOLD OUT</span>
                                        </template>
                                        <template x-if="selectedEvent.max_attendees === null">
                                            <span class="text-green-400 font-semibold">Unlimited spots</span>
                                        </template>
                                        <template x-if="selectedEvent.remaining_spots > 0">
                                            <span class="text-green-400 font-semibold" 
                                                  x-text="selectedEvent.remaining_spots + ' spots left'">
                                            </span>
                                        </template>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="mt-6">
                                        <template x-if="selectedEvent.remaining_spots === null">
                                            <button 
                                                class="w-full bg-gray-400 text-white px-6 py-2 rounded shadow cursor-not-allowed"
                                                disabled
                                            >
                                                SOLD OUT
                                            </button>
                                        </template>
                                        <template x-if="selectedEvent.max_attendees === null || selectedEvent.remaining_spots > 0">
                                            <button 
                                                class="w-full bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700"
                                                @click="alert('You are attending ' + selectedEvent.name); open = false;"
                                            >
                                                Attend
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection