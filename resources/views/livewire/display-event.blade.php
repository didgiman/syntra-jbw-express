{{-- load the countdown script --}}
@push('scripts')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endpush

<div class="max-w-4xl mx-auto" x-data="{ showImageModal: false }">
    {{-- Header with Event Title and Message --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-center">{{ $event->name }}</h1>
        @if ($message)
            <div class="mt-4 text-green-500 font-bold text-xl text-center">
                {!! $message !!}
            </div>
        @endif
    </div>

    {{-- Main Content Grid --}}
    <div class="grid md:grid-cols-2 gap-8">
        {{-- Left Column: Event Details --}}
        <div class="space-y-6">
            {{-- Time Section --}}
            <div class="bg-gray-800 p-6 rounded-lg">
                <div class="space-y-2">
                    <p>
                        <b class="text-gray-400">Starts:</b> 
                        <span class="text-green-500 block text-lg">
                            {{ $event->start_time->format('l, F jS Y H:i') }}
                        </span>
                    </p>
                    <p>
                        <b class="text-gray-400">Ends:</b> 
                        <span class="text-red-500 block text-lg">
                            {{ $event->end_time->format('l, F jS Y H:i') }}
                        </span>
                    </p>
                </div>

                {{-- Status/Countdown --}}
                <div class="mt-4 p-3 bg-gray-700 rounded">
                    @if($event->end_time && now() > $event->end_time)
                        <span class="text-red-500 font-semibold">Event has ended</span>
                    @elseif(now() > $event->start_time)
                        <span class="text-yellow-500 font-semibold">Event in progress</span>
                    @else
                        <div class="text-yellow-300 font-semibold"
                             x-data
                             x-init="setInterval(() => $el.textContent = 'Time until event starts: ' + calculateTimeLeft('{{ $event->start_time }}', '{{ $event->end_time }}'), 1000)">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Location Section --}}
            <div class="bg-gray-800 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-3">Location</h2>
                @if($event->location)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->location) }}"
                       class="text-blue-400 hover:text-blue-300 hover:underline flex items-center gap-2"
                       target="_blank"
                       rel="noopener noreferrer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                        {{ $event->location }}
                    </a>
                @else
                    <span class="text-gray-400">Location: TBA</span>
                @endif
            </div>

            {{-- Description Section --}}
            <div class="bg-gray-800 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-3">About this Event</h2>
                <p class="text-gray-300">{{ $event->description }}</p>
            </div>

            {{-- Actions Section --}}
            <div class="bg-gray-800 p-6 rounded-lg">
                {{-- Availability Status --}}
                <div class="mb-4">
                    @if(is_null($event->max_attendees))
                        <p class="text-blue-400">
                            <b>{{ $event->attendees->count() }}</b> attending - Unlimited spots available
                        </p>
                    @else
                        @php
                            $remainingSpots = $event->max_attendees - $event->attendees->count();
                        @endphp
                        <p class="text-sm {{ $remainingSpots > 0 ? 'text-blue-400' : 'text-red-500 font-bold text-base' }}">
                            <b>{{ $event->attendees->count() }}</b> attending - 
                            @if($remainingSpots <= 0)
                                SOLD OUT
                            @else
                                {{ $remainingSpots }} spots remaining
                            @endif
                        </p>
                    @endif
                </div>

                {{-- Actions --}}
                @if ($event->user_id === Auth::id())
                    <p class="text-violet-400 mb-4">You are hosting this event</p>
                    <a href="{{ route('user.events.hosting.edit', ['event' => $event->id]) }}"
                       class="btn btn-primary-inverted w-full text-center block">
                        Edit event details
                    </a>
                @elseif ($event->currentUserAttendee)
                    <p class="text-violet-400 mb-4">You are attending this event</p>
                    <div class="flex gap-4">
                        <button class="btn btn-danger flex-1"
                                wire:click="unattend({{ $event->id }})"
                                wire:confirm="Are you sure?">
                            Unattend
                        </button>
                        <button class="btn btn-primary flex-1"
                                wire:click.prevent="downloadTicket({{ $event->currentUserAttendee->id }})">
                            Download Ticket
                        </button>
                    </div>
                @elseif(!is_null($event->max_attendees) && $remainingSpots <= 0)
                    <p class="text-red-500 font-bold text-center">This event is sold out</p>
                @else
                    <button class="btn btn-primary w-full"
                            wire:click="attend({{ $event->id }})">
                        Attend Event
                    </button>
                    @guest
                        <p class="text-sm text-gray-400 text-center mt-2">
                            You will need to log in or register before attending an event
                        </p>
                    @endguest
                @endif
            </div>
        </div>

        {{-- Right Column: Image with Event Type Badge --}}
        <div class="relative">
            {{-- Event Type Badge --}}
            <span class="text-xs text-white py-1 px-2 rounded absolute -top-2 shadow uppercase -left-2 md:-left-4 z-10"
                  style="background-color: {{ $event->type->color }};">
                {{ $event->type->description }}
            </span>

            @if($event->image)
                {{-- Clickable Image --}}
                <img src="{{ $event->image }}"
                     alt="{{ $event->name }}"
                     class="w-full h-[400px] object-cover rounded-lg shadow-lg sticky top-4 cursor-pointer"
                     @click="showImageModal = true">

                {{-- Full Size Image Modal --}}
                <div x-show="showImageModal" 
                     style="display: none;" 
                     class="fixed inset-0 overflow-hidden z-50"
                     @keydown.escape.window="showImageModal = false"
                     x-init="$watch('showImageModal', value => {
                         if (value) {
                             document.body.classList.add('overflow-hidden');    {{-- Prevent background scroll --}}
                         } else {
                             document.body.classList.remove('overflow-hidden'); {{-- Restore background scroll --}}
                         }
                     })"
                >
                    {{-- Modal Backdrop --}}
                    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" 
                         @click="showImageModal = false">
                    </div>

                    {{-- Modal Container --}}
                    <div class="fixed inset-0 flex items-center justify-center pointer-events-none">
                        {{-- Modal Content --}}
                        <div class="relative max-w-7xl p-4 pointer-events-auto">
                            {{-- Close Button --}}
                            <button @click="showImageModal = false" 
                                    class="absolute top-0 right-0 -mr-4 -mt-4 text-gray-400 hover:text-white z-10 flex items-center gap-2">
                                <span class="text-sm font-medium">Close</span>
                                <span class="text-2xl">&times;</span>
                            </button>
                            
                            {{-- Full Size Image --}}
                            <img src="{{ $event->image }}" 
                                 alt="{{ $event->name }}"
                                 class="max-w-full max-h-[90vh] object-contain rounded-lg">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@script
<script>
    $wire.on('download-ticket', (url) => {
        window.location.href = url.url;
    });
</script>
@endscript