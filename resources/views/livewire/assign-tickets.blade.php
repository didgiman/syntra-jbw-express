<div>
    @if(count($tickets) > 1)
        <h2 class="text-xl font-bold mb-4">Assign tickets</h2>
        <p>You have purchased {{ $nbrTickets }} tickets for this event.</p>
        <p class="mb-4">Assign {{ $nbrTickets-1 }} ticket(s) to other users.</p>
        @foreach ($tickets as $ticket)
            <div class="mb-2 bg-gray-700 p-2 rounded" wire:key="wrapper-{{ $ticket->id }}">
                <livewire:assign-ticket
                    :attendee="$ticket"
                    :key="$ticket->id"
                    :isFirst="$loop->first"
                />
            </div>
        @endforeach
    @endif
</div>
