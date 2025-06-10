<div>
    @foreach ($events as $event)
        <div class="relative border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
            
            <div>
                <span class="text-xs bg-violet-500 text-white py-1 px-2 rounded absolute top-0 shadow uppercase -left-2 md:-left-4">{{ $event->type->description }}</span>
                <div class="flex gap-4">
                    <div class="w-20 flex justify-center">
                        <img src="{{ $event->image }}" class="w-20 min-w-20 h-20 object-cover rounded-lg">
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                        <p>{{ $event->start_time->format('l, F jS Y H:i') }}</p>
                        @if ($event->relationLoaded('attendees'))
                            {{-- Only display the number of attendess if the attendees have been eager loaded --}}
                            <p class="text-sm mt-2"><b>{{ $event->attendees->count() }}</b> people attending</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $events->links(data: ['scrollTo' => false]) }}
    </div>
</div>
