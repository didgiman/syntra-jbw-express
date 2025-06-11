<div class="relative border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
    <div>
        <span class="text-xs bg-violet-500 text-white py-1 px-2 rounded absolute top-0 shadow uppercase -left-2 md:-left-4">{{ $event->type->description }}</span>
        <div class="flex gap-4">
            <div class="w-20 flex justify-center">
                <img src="{{ $event->image }}" class="w-20 min-w-20 h-20 object-cover rounded-lg">
            </div>
            <div>
                @if ($this->view === 'all')
                    <h2 class="text-xl font-bold"><a href="{{ route('events.single', ['event' => $event->id]) }}">{{ $event->name }}</a></h2>
                @else
                    <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                @endif
                <p>{{ $event->start_time->format('l, F jS Y H:i') }}</p>
                {{-- Live Countdown --}}
                <div class="text-yellow-300 text-sm mb-2"
                        x-data
                        x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft('{{ $event->start_time }}'), 1000)">
                </div>
                @if ($event->relationLoaded('attendees'))
                    <p class="text-sm mt-2"><b>{{ $event->attendees->count() }}</b> people attending</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Named slot for action buttons --}}
    <div>
        {{ $buttons ?? '' }}
    </div>
</div>
