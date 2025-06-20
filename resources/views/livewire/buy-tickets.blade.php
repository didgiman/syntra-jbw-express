<div class="buy-tickets">
    <h2 class="text-white text-xl font-bold mb-4">Buy @if ($event->currentUserAttendee) more @endif tickets for this event</h2>

    @if ($message)
        <p class="text-violet-400 pb-2">{{ $message }}</p>
    @endif

    @error('numberOfTickets')
        <p class="text-red-600 pb-2">{{ $message }}</p>
    @enderror

    @php
        $availableSpots = $event->available_spots;
    @endphp

    @guest
        <div>
            <div class="pb-4 flex justify-between">
                <span>Ticket price:</span>
                <span>&euro;{{ $event->price }}</span>
            </div>
            <button class="btn btn-primary w-full" wire:click.prevent="startBuying">Buy Tickets</button>
            <p class="text-sm text-gray-400 text-center mt-2">
                You will need to log in or register before buying tickets
            </p>
        </div>
    @else

        @if (!is_null($event->max_attendees) && $availableSpots == 0)
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
                        @for ($i = 1; $i <= min(10, is_null($event->max_attendees) ? 10 : $availableSpots); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-between text-xl font-bold border-t-1 pt-2 mt-2">
                    <p>Total:</p>
                    <p>&euro;{{ $totalPrice }}</p>
                </div>
                <div class="mt-4 @if($showPaymentForm) hidden @endif">
                    <button
                        type="submit"
                        class="btn btn-primary block w-full md:w-full"
                    >Continue</button>
                </div>
                @if($showPaymentForm)
                    <div class="form-input mt-6">
                        <label>Creditcard number</label>
                        <input type="text" wire:model="cc_card" placeholder="xxxx-xxxx-xxxx-xxxx"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1-').slice(0, 19)"
                        >
                        @error('cc_card')
                            <div class="validationError">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-input flex gap-2">
                        <div>
                            <label>Expiry date (mm/yy)</label>
                            <input type="text" wire:model="cc_valid" placeholder="mm/yy"
                                oninput="this.value = this.value.replace(/[^\d\/]/g, '').replace(/(\d{2})(?=\d)/, '$1/').slice(0, 5)"
                            >
                            @error('cc_valid')
                                <div class="validationError">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label>CVC</label>
                            <input type="text" wire:model="cc_cvc" placeholder="xxx" maxlength="3">
                            @error('cc_cvc')
                                <div class="validationError">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-primary block w-full md:w-full"
                        >Buy Tickets</button>
                    </div>
                @endif
            </form>
        @endif
    @endguest
</div>
