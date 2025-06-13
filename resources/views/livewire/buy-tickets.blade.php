<div class="mt-8">

    <p class="text-primary pb-2">{{ $message }}</p>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($userIsAttending)
        <p>You are attending this event</p>
    @elseif (!$buyingStarted)
        <div>
            {{-- TO DO: hide the button if there are no more tickets left for the event --}}
            <button class="btn btn-primary w-full" wire:click.prevent="startBuying">Buy Tickets</button>
        </div>
    @else
        <h2 class="text-white text-xl font-bold mb-4">Buy tickets for this event</h2>
        <p class="mb-2 text-sm">Select all users for which you want to buy a ticket</p>
        <form wire:submit="buy">
            <div class="mb-4">
                {{-- TO DO: hide the user search field if there are no more tickets left for the event --}}
                <livewire:user-search buttonText="Add" onSelect="attend:userSelected" />
            </div>

            <div class="form-input relative">

                <p>Selected users: @if (count($attendees) == 0) <i>none</i>@endif </p>

                <ul class="list-disc ml-5">
                @foreach ($attendees as $index => $attendee)
                    <li class="mb-2">
                        <div class="flex justify-between items-center">
                            <span>{{ $attendee->name }} ({{ $attendee->id }})</span>
                            {{-- @if($attendee->id !== auth()->id()) --}}
                                <i class="fa-solid fa-xmark text-red-600 hover:text-red-500 cursor-pointer" wire:click.prevent="removeAttendee({{ $index }})"></i>
                            {{-- @endif --}}
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="mt-8">
                @error('attendees')
                    <div class="validationError mb-2">{{ $message }}</div>
                @enderror
                <button
                    type="submit"
                    class="btn btn-primary block w-full md:w-full"
                    @if (count($attendees) === 0) disabled @endif
                >Continue</button>
            </div>
        </form>
    @endif
</div>
