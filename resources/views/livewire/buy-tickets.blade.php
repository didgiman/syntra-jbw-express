<div>
    <h2 class="text-white text-xl font-bold mb-4">Buy tickets for this event</h2>

    <p class="text-primary pb-2">{{ $message }}</p>

    @guest
        <div>
            <div class="pb-4 flex justify-between">
                <span>Ticket price:</span>
                <span>&euro;{{ $event->price }}</span>
            </div>
            <button class="btn btn-primary w-full" wire:click.prevent="startBuying">Buy Tickets</button>
            @guest
                <p class="text-sm text-gray-400 text-center mt-2">
                    You will need to log in or register before buying tickets
                </p>
            @endguest
        </div>
    @else

        @if ($event->available_spots == 0)
            <p class="text-red-500 text-lg font-bold">Event is sold out</p>
        @elseif ($ticketsPurchased)
            <button class="btn btn-primary w-full" wire:click.prevent="startBuying">Buy More Tickets</button>
        @else
            <div class="pb-4 flex justify-between">
                <span>Ticket price:</span>
                <span>&euro;{{ $event->price }}</span>
            </div>
            <form wire:submit="buy">
                <div class="form-input flex items-center justify-between">
                    <label class="w-full">Number of tickets</label>
                    <select wire:model.live="numberOfTickets" class="w-1/5!">
                        @for ($i = 1; $i <= min(10, $event->available_spots); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-between text-xl font-bold border-t-1 pt-2 mt-2">
                    <p>Total:</p>
                    <p>&euro;{{ $totalPrice }}</p>
                </div>
                <div class="mt-4">
                    <button
                        type="submit"
                        class="btn btn-primary block w-full md:w-full"
                    >Buy Tickets</button>
                </div>
            </form>
        @endif
    @endguest
</div>
