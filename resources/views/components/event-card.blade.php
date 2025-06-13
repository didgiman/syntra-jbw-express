<div class="relative border-b-2 border-gray-800 p-6 rounded-lg overflow-hidden {{ session('highlight-event') === $event->id ? 'bg-green-900 p-6' : '' }}">
    <div class="flex gap-6">
        {{-- Image with Type Badge --}}
        <div class="relative">
            {{-- Type Badge --}}
            <span class="text-xs text-white py-1 px-2 rounded absolute -top-2 -left-2 shadow uppercase z-10"
                style="background-color: {{ $event->type->color }};">
                {{ $event->type->description }}
            </span>
            <img src="{{ $event->image }}" class="w-36 h-36 object-cover rounded-lg">
        </div>
        
        {{-- Event Info --}}
        <div class="flex-1">
            <div class="flex justify-between items-start">
                {{-- Title and Location --}}
                <div class="w-1/2 pr-4">
                    @if($event->end_time < now())
                        <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                    @else
                        <h2 class="text-xl font-bold"><a
                        href="{{ route('events.single', ['event' => $event->id]) }}">{{ $event->name }}</a></h2>
                    @endif
                    
                    {{-- Location --}}
                    @if($event->location)
                        <p class="text-gray-400 text-sm flex items-center mt-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                            {{ $event->location }}
                        </p>
                    @endif
                </div>
                
                {{-- Attendance Info --}}
                @if ($event->relationLoaded('attendees'))
                    <div class="text-right w-1/2 pl-4">
                        @if(is_null($event->max_attendees))
                            <span class="text-blue-400 text-sm">
                                <b>{{ $event->attendees->count() }}</b> attending
                            </span>
                        @else
                            @php
                                $remainingSpots = $event->max_attendees - $event->attendees->count();
                            @endphp
                            <span class="text-sm {{ $remainingSpots > 0 ? 'text-blue-400' : 'text-red-500' }}">
                                <b>{{ $event->attendees->count() }}</b> attending<br>
                                @if($remainingSpots <= 0)
                                    <span class="font-bold">SOLD OUT</span>
                                @else
                                    {{ $remainingSpots }} spots left
                                @endif
                            </span>
                        @endif
                    </div>
                @endif
            </div>
            
            {{-- Times and Status --}}
            <div class="mt-4 flex flex-col space-y-4">
                {{-- Times --}}
                <div>
                    <p class="text-gray-400 text-sm">Starts: <span class="text-green-500 font-medium">{{ $event->start_time->format('D, M j, Y H:i') }}</span></p>
                    <p class="text-gray-400 text-sm">Ends: <span class="text-red-500 font-medium">{{ $event->end_time->format('D, M j, Y H:i') }}</span></p>
                </div>
                
                {{-- Status/Countdown and Button --}}
                <div class="flex justify-between items-center">
                    <div>
                        @if($event->end_time && now() > $event->end_time)
                            <span class="text-red-500 text-sm font-semibold">Event has ended</span>
                        @elseif(now() > $event->start_time)
                            <span class="text-yellow-500 text-sm font-semibold">Event in progress</span>
                        @else
                            <div class="text-yellow-300 text-sm font-semibold"
                                x-data
                                x-init="setInterval(() => $el.textContent = 'Time until event starts: ' + calculateTimeLeft('{{ $event->start_time }}', '{{ $event->end_time }}'), 1000)">
                            </div>
                        @endif
                    </div>
                    
                    {{-- Action Button --}}
                    <div>
                        {{ $buttons ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
