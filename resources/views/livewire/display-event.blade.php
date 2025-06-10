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
        <p><b>Ends:</b> {{ $event->end_time->format('l, F jS Y H:i') }}
        <p>{{ $event->description }}</p>
        <div>
            <button class="btn btn-primary btn-sm"
                wire:click="attend({{ $event->id }})"
            >Attend Event</button>

            @guest
                <p class="text-sm italic pt-2">You will need to log in or register before attending an event</p>
            @endauth
        </div>
    </div>
</div>
