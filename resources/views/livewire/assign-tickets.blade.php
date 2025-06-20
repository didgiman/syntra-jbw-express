<div>
    @if(count($tickets) > 1)
        <h2 class="text-xl font-bold mb-4">Assign your tickets</h2>
        <p>You have purchased {{ $nbrTickets }} tickets for this event.</p>
        @if ($nbrTicketsAssignedToUser > 1)
            <p class="mb-4 text-red-500">Assign at least {{ $nbrTickets-1 }} ticket(s) to other users.</p>
        @else
            <p class="mb-4 text-green-500">All tickets are correctly assigned.</p>
        @endif
        @foreach ($tickets as $ticket)
            <div class="mb-2 bg-gray-700 p-2 rounded" wire:key="wrapper-{{ $ticket->id }}">
                <livewire:assign-ticket
                    :attendee="$ticket"
                    :key="$ticket->id"
                    :index="$loop->index"
                />
            </div>
        @endforeach
    @endif
</div>
