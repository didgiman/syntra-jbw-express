<div>
    <p>Ticket <b>{{ $attendee->id }}</b> (assigned to {{ $attendee->user->name }})
    @if (!$isFirst)
        @if (!$isAssigned)
            <livewire:user-search onSelect="ticket-user-selected.{{ $attendee->id }}" /></p>
        @else
            : <span class="text-violet-500">assigned to {{ $attendee->user->name }} - {{ $attendee->id }} - {{ $attendee->user->id }}</span>
        @endif
        <div class="text-violet-500">{{ $message }}</div>
    @endif
</div>