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
        <p><b>Starts:</b> {{ $event->start_time->format('l, F jS Y H:i') }}
        {{-- Live Countdown --}}
        <div class="text-yellow-300 text-sm mb-2"
                x-data
                x-init="setInterval(() => $el.textContent = 'Event is starting in: ' + calculateTimeLeft('{{ $event->start_time }}'), 1000)">
        </div>
        <p><b>Ends:</b> {{ $event->end_time->format('l, F jS Y H:i') }}
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