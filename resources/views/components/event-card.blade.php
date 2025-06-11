<div
    class="relative border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
    <div>
        <span class="text-xs text-white py-1 px-2 rounded absolute top-0 shadow uppercase -left-2 md:-left-4"
            style="background-color: {{ $event->type->color }};">
            {{ $event->type->description }}
        </span>
        <div class="flex gap-4">
            <div class="w-20 flex justify-center">
                <img src="{{ $event->image }}" class="w-20 min-w-20 h-20 object-cover rounded-lg">
            </div>
            <div>
                @if ($this->view === 'all')
                    <h2 class="text-xl font-bold"><a
                            href="{{ route('events.single', ['event' => $event->id]) }}">{{ $event->name }}</a></h2>
                @else
                    <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                @endif
                <p class="text-green-500">Start: {{ $event->start_time->format('l, F jS Y H:i') }}</p>
                <p class="text-red-500">End: {{ $event->end_time->format('l, F jS Y H:i') }}</p>
                
                {{-- Status Indicators with Countdown --}}
                <div class="mt-2">
                    @if($event->end_time && now() > $event->end_time)
                        <span class="text-red-500 font-semibold">Event has ended</span>
                    @elseif(now() > $event->start_time)
                        <span class="text-yellow-500 font-semibold">Event in progress</span>
                    @else
                        {{-- Live Countdown only shows for upcoming events --}}
                        <div class="text-yellow-300 font-semibold"
                            x-data
                            x-init="setInterval(() => $el.textContent = 'Event starts in: ' + calculateTimeLeft('{{ $event->start_time }}', '{{ $event->end_time }}'), 1000)">
                        </div>
                    @endif
                    
                    @if ($event->relationLoaded('attendees'))
                        <p class="text-sm mt-2"><b>{{ $event->attendees->count() }}</b> people are attending</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Named slot for action buttons --}}
    <div>
        {{ $buttons ?? '' }}
    </div>
</div>
