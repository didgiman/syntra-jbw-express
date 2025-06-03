<div class="m-auto w-1/2 mb-4">
    <form wire:submit="save">
        <div class="mb-3">
            <label class="block" for="event-name">Event name</label>
            <input
                type="text"
                id="event-name"
                class="p-2 w-full border rounded-md bg-gray-700 text-white"
                wire:model="name"
            >
            @error('name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="block" for="event-description">Event description</label>
            <textarea
                id="event-description"
                class="p-2 w-full border rounded-md bg-gray-700 text-white"
                wire:model="description"
            ></textarea>
            @error('description')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="block" for="event-start-time">Event start time</label>
            <input
                type="datetime-local"
                id="event-start-time"
                class="p-2 w-full border rounded-md bg-gray-700 text-white"
                wire:model="start_time"
            >
            @error('start_time')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="block" for="event-start-time">Event end time</label>
            <input
                type="datetime-local"
                id="event-end-time"
                class="p-2 w-full border rounded-md bg-gray-700 text-white"
                wire:model="end_time"
            >
            @error('end_time')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 flex justify-between mt-8">
            <a href="{{ route('user.events') }}"
                class="btn"
            >Cancel</a>
            <button
                type="submit"
                class="btn btn-primary"
            >Save Event</button>
        </div>
    </form>
</div>
