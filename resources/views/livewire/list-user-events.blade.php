<div class="space-y-2">

    @if ($message)
        <div class="text-green-500 font-bold text-xl text-center mb-4">
            {!! $message !!}
        </div>
    @endif

    @if ($events->isEmpty())
        <div class="space-y-4">
        @switch ($view)
            @case('attending')
                <p class="text-center">You are not attending any events</p>
                <p class="text-center"><a href="{{ route('events') }}" class="text-violet-500 hover:underline">Find an event to attend</a></p>
            @break
            @case('attending.past')
                <p class="text-center">You have not attended any events</p>
                <p class="text-center"><a href="{{ route('events') }}" class="text-violet-500 hover:underline">Find an event to attend</a></p>
            @break
            @case('hosting')
                <p class="text-center">You are not hosting any events</p>
            @break
            @case('hosting.past')
                <p class="text-center">You have not hosted any events</p>
            @break
        @endswitch
        </div>
    @endif

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

            @if ($view === 'hosting')
                <div class="flex flex-col md:flex-row gap-2 items-end">
                    <a
                        href="{{ route('user.events.hosting.edit', ['event' => $event->id]) }}"
                        wire:navigate
                        class="btn btn-sm"
                    >Edit</a>

                    <button class="btn btn-danger btn-sm"
                        wire:click="delete({{ $event->id }})"
                        wire:confirm="Are you sure?">Delete</button>

                    {{-- TO DO: this button should be removed --}}
                    <button class="btn btn-primary btn-sm"
                        wire:click="attend({{ $event->id }})"
                    >Attend (TBR)</button>
                </div>
            @elseif ($view === 'attending')
                <div class="flex flex-col md:flex-row gap-2 items-end">
                    <button class="btn btn-danger btn-sm"
                        wire:click="unattend({{ $event->id }})"
                        wire:confirm="Are you sure?">Unattend</button>

                    <button class="btn btn-primary btn-sm"
                        wire:click.prevent="downloadTicket({{ $event->attendee_id }})"
                        >Download Ticket</button>
                </div>
            @endif
        </div>
    @endforeach

    <div class="mt-3">
        {{ $events->links(data: ['scrollTo' => false]) }}
    </div>
</div>

@script
<script>
    $wire.on('download-ticket', (url) => {
        window.location.href = url.url;
    });
</script>
@endscript