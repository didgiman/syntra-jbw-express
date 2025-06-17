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
        @php
            $userTicketsCount = $event->user_attending_count ?? 0;
        @endphp
        <x-event-card :event="$event" :view="$view">
            @slot('buttons')
                {{-- ACTION BUTTONS --}}    
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
                    </div>
                @elseif ($view === 'attending')
                    <div class="flex flex-col md:flex-row gap-2 items-end">
                        @if ($event->price == 0)
                            <button class="btn btn-danger btn-sm"
                                wire:click="unattend({{ $event->id }})"
                                wire:confirm="Are you sure?">Unattend</button>
                        @endif

                        <button class="btn btn-primary btn-sm"
                            wire:click.prevent="downloadTicket({{ $event->id }})"
                        >Download {{ $userTicketsCount }} Ticket{{ $userTicketsCount > 1 ? 's' : '' }}</button>
                    </div>
                @endif
            @endslot
        </x-event-card>
    @endforeach

    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>

@script
<script>
    $wire.on('download-ticket', (url) => {
        window.location.href = url.url;
    });
</script>
@endscript