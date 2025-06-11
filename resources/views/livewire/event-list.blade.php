<div>
    <ul>
        @foreach ($events as $event)
            <li class="mb-2 p-4 border rounded shadow hover:bg-black text-white relative">
                {{-- Type text in top right --}}
                <span class="absolute top-2 right-2 text-sm font-bold text-white">
                    {{ $event->type ? strtoupper($event->type->description) : 'NO TYPE' }}
                </span>

                <div class="flex gap-4 items-start">
                    {{-- Event Image --}}
                    @if ($event->image)
                        <img src="{{ $event->image }}" alt="{{ $event->name }} poster"
                            class="w-32 h-32 object-cover rounded-lg"
                            onerror="console.error('Failed to load image:', this.src)">
                    @endif

                    {{-- Event Details --}}
                    <div class="flex-1">
                        {{-- Event Name --}}
                        <div class="font-bold text-lg mb-2">{{ $event->name }}</div>

                        {{-- Start Time --}}
                        <div class="text-red-300 text-sm font-bold mb-2">
                            Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                        </div>

                        {{-- Countdown --}}
                        <div class="text-yellow-300 text-sm mb-2" x-data x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft('{{ $event->start_time }}'), 1000)">
                        </div>

                        {{-- Available Spots --}}
                        <div class="mt-2">
                            @if (is_null($event->max_attendees))
                                <span class="text-green-600 font-semibold">Unlimited spots</span>
                            @else
                                @php
                                    $remainingSpots = $event->max_attendees - $event->attendees->count();
                                @endphp
                                @if ($remainingSpots <= 0)
                                    <span class="text-red-600 font-semibold">SOLD OUT</span>
                                @else
                                    <span class="text-green-600 font-semibold">{{ $remainingSpots }} spots left</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{$events->links()}}
</div>
