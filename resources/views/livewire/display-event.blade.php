{{-- load the countdown script --}}
@push('scripts')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endpush

<div>
    <h1 class="text-3xl font-bold mb-8 text-center">{{ $event->name }}</h1>
    @if ($message)
        <div class="text-green-500 font-bold text-xl text-center mb-8">
            {!! $message !!}
        </div>
    @endif
    <div class="space-y-6">
        <img src="{{ $event->image }}" class="w-full md:float-right md:w-1/2">
        <p><b>Starts:</b> <span class="text-green-500">{{ $event->start_time->format('l, F jS Y H:i') }}</span></p>
        <p><b>Ends:</b> <span class="text-red-500">{{ $event->end_time->format('l, F jS Y H:i') }}</span></p>

        {{-- Status Indicators with Countdown --}}
        <div class="mt-2">
            @if($event->end_time && now() > $event->end_time)
                <span class="text-red-500 font-semibold">Event has ended</span>
            @elseif(now() > $event->start_time)
                <span class="text-yellow-500 font-semibold">Event in progress</span>
            @else
                {{-- Live Countdown only shows for upcoming events --}}
                <div class="text-yellow-300 text-sm"
                    x-data
                    x-init="setInterval(() => $el.textContent = 'Event starts in: ' + calculateTimeLeft('{{ $event->start_time }}', '{{ $event->end_time }}'), 1000)">
                </div>
            @endif
        </div>

        <p>{{ $event->description }}</p>
        <div>
            @if ($event->user_id === Auth::id())
                <p class="text-sm text-violet-500">You are hosting this event</p>
                <a href="{{ route('user.events.hosting.edit', ['event' => $event->id])}}" class="btn btn-primary-inverted inline-block mt-4">Edit event details</a>
            @elseif ($event->currentUserAttendee)
                <p class="text-violet-600 text-2xl font-bold mb-4">You are attending this event</p>

                <button class="btn btn-danger btn-sm"
                    wire:click="unattend({{ $event->id }})"
                    wire:confirm="Are you sure?">Unattend</button>

                <button class="btn btn-primary btn-sm"
                    wire:click.prevent="downloadTicket({{ $event->currentUserAttendee->id }})"
                >Download Ticket</button>
            @else
                <button class="btn btn-primary"
                    wire:click="attend({{ $event->id }})"
                >Attend Event</button>
                @guest
                    <p class="text-sm italic pt-2">You will need to log in or register before attending an event</p>
                @endauth
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