<div>
    <p>Ticket <b>{{ $attendee->id }}</b> @if ($isFirst) (Your ticket) @endif</p>
    @if (!$isFirst)
        @if (!$isAssigned)
            <livewire:user-search onSelect="ticket-user-selected.{{ $attendee->id }}" />
        @endif
        <div class="text-violet-500">{{ $message }}</div>
    @endif
</div>