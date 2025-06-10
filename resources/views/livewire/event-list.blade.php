<div>
    @foreach ($events as $event)
        <x-event-card :event="$event" :view="$view">
            @slot('buttons')
                <a href="{{ route('events.single', ['event' => $event->id]) }}" class="btn btn-primary">Details</a>
            @endslot
        </x-event-card>
    @endforeach

    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>
