{{-- <div>
    @if(count($tickets) > 1)
        <h2 class="text-xl font-bold mb-4">Assign {{ $nbrTickets }} tickets</h2>
        @foreach ($tickets as $ticket)
            <div class="mb-2" wire:key="{{ $ticket->id }}">
                @if($loop->first)
                    <p class="mb-2">Ticket <b>{{ $ticket->id }}</b>: <span class="text-violet-500">{{ $ticket->user->name }}</span>
                @else
                    <livewire:assign-ticket :attendee="$ticket" :key="$ticket->id" />
                @endif
            </div>
        @endforeach
    @endif
</div> --}}

<div>
    @if(count($tickets) > 1)
        <h2 class="text-xl font-bold mb-4">Assign {{ $nbrTickets }} tickets</h2>
        @foreach ($tickets as $ticket)
            <div class="mb-2" wire:key="wrapper-{{ $ticket->id }}">
                <livewire:assign-ticket
                    :attendee="$ticket"
                    :key="$ticket->id"
                    :isFirst="$loop->first"
                />
            </div>
        @endforeach
    @endif
</div>
