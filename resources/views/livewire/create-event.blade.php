<div class="m-auto md:w-2/3 mb-4">
    <form wire:submit="save">
        <div class="form-input">
            <label class="block" for="event-type">Event type</label>
            <select 
                id="event-type"
                wire:model="type_id"
            >
                <option value="">- Select event type -</option>
                @foreach ($eventTypes as $eventType)
                    <option value="{{ $eventType->id }}">{{ $eventType->description }}</option>
                @endforeach
            </select>
            @error('type_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-name">Event name</label>
            <input
                type="text"
                id="event-name"
                wire:model="name"
            >
            @error('name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-description">Event description</label>
            <textarea
                id="event-description"
                wire:model="description"
            ></textarea>
            @error('description')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-location">Event location</label>
            <input
                type="text"
                id="event-location"
                wire:model="location"
            >
            @error('location')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-start-time">Event start time</label>
            <input
                type="datetime-local"
                id="event-start-time"
                wire:model="start_time"
            >
            @error('start_time')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-start-time">Event end time</label>
            <input
                type="datetime-local"
                id="event-end-time"
                wire:model="end_time"
            >
            @error('end_time')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-max-attendees">Maximum attendees (<span class="text-sm">Leave blank for no limit</span>)</label>
            <input
                type="number"
                min="0"
                id="event-max-attendees"
                wire:model="max_attendees"
            >
            @error('max_attendees')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-price">Ticket price (<span class="text-sm">Insert 0 when event is free to attend</span>)</label>
            <input
                type="text"
                min="0"
                id="event-price"
                wire:model="price"
            >
            @error('price')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label for="description">Photo/poster:</label>
            <input type="file" wire:model="poster">
            @error('poster')
                <div class="validationError">{{ $message }}</div>
            @enderror
            @if ($poster)
                <img class="w-full" src="{{ $poster->temporaryUrl() }}">
            @endif
        </div>
        <div class="mb-3 md:flex md:flex-row-reverse md:gap-4 justify-between mt-8">
            <button
                type="submit"
                class="btn btn-primary block w-full md:w-1/3"
            >Save Event</button>

            <a href="{{ route('user.events') }}"
                class="btn block w-full mt-4 md:mt-0 md:w-1/3"
            >Cancel</a>
        </div>
    </form>
</div>
