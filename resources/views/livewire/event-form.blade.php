<div class="m-auto md:w-2/3 mb-4">
    <form wire:submit="save">
        <div class="form-input">
            <label class="block" for="event-type">Event type</label>
            <select 
                id="event-type"
                wire:model="form.type_id"
            >
                <option value="">- Select event type -</option>
                @foreach ($form->eventTypes as $eventType)
                    <option value="{{ $eventType->id }}">{{ $eventType->description }}</option>
                @endforeach
            </select>
            @error('form.type_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-name">Event name</label>
            <input
                type="text"
                id="event-name"
                wire:model="form.name"
            >
            @error('form.name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-description">Event description</label>
            <textarea
                id="event-description"
                wire:model="form.description"
            ></textarea>
            @error('form.description')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <label class="block" for="event-location">Event location</label>
            <input
                type="text"
                id="event-location"
                wire:model="form.location"
            >
            @error('form.location')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="md:flex md:gap-4">
            <div class="form-input md:w-full">
                <label class="block" for="event-start-time">Event start time:</label>
                <input
                    type="datetime-local"
                    id="event-start-time"
                    wire:model="form.start_time"
                    min="{{ now()->format('Y-m-d\TH:i') }}"
                >
                @error('form.start_time')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-input md:w-full">
                <label class="block" for="event-start-time">Event end time</label>
                <input
                    type="datetime-local"
                    id="event-end-time"
                    wire:model="form.end_time"
                    min="{{ now()->format('Y-m-d\TH:i') }}"
                >
                @error('form.end_time')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="md:flex md:gap-4">
            <div class="form-input md:w-full">
                <label class="block" for="event-max-attendees">Maximum attendees (<span class="text-sm">Leave blank for no limit</span>)</label>
                <input
                    type="number"
                    min="0"
                    id="event-max-attendees"
                    wire:model="form.max_attendees"
                >
                @error('form.max_attendees')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-input md:w-full">
                <label class="block" for="event-price">Ticket price (<span class="text-sm">Insert 0 when event is free to attend</span>)</label>
                <input
                    type="text"
                    min="0"
                    id="event-price"
                    wire:model="form.price"
                >
                @error('form.price')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-input">
            <label for="description">Photo/poster:</label>
            <div
                x-data="{ isDragging: false }"
                x-on:dragover.prevent="isDragging = true"
                x-on:dragleave.prevent="isDragging = false"
                x-on:drop.prevent="
                    isDragging = false;
                    $refs.fileInput.files = $event.dataTransfer.files;
                    $refs.fileInput.dispatchEvent(new Event('change'))
                "
                x-on:click="$refs.fileInput.click()"
                class="border-2 border-dashed rounded-md p-6 text-center cursor-pointer transition"
                :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
            >
                <input type="file" wire:model="form.poster" x-ref="fileInput" class="hidden" accept=".jpg,.jpeg,.png,.gif" />
                <p class="text-gray-500">Drag and drop a file here or click to select one</p>
                
                @error('form.poster')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @else
                    @if ($form->poster)
                        <div class="flex flex-col justify-center items-center mt-2">
                            <div class="text-sm text-gray-500">New image:</div>
                            <img class="w-1/3" src="{{ $form->poster->temporaryUrl() }}">
                        </div>
                    @elseif ($form->image)
                        <div class="flex flex-col justify-center items-center mt-2">
                            <div class="text-sm text-gray-500">Current image:</div>
                            <img class="w-1/3" src="{{ $form->image }}">
                        </div>
                    @endif
                @enderror
            </div>
        </div>
        <div class="mb-3 md:flex md:flex-row-reverse md:gap-4 justify-between mt-8">
            <button
                type="submit"
                class="btn btn-primary block w-full md:w-1/3"
            >Save Event</button>

            <a href="{{ route('user.events.hosting') }}"
                class="btn block w-full mt-4 md:mt-0 md:w-1/3"
            >Cancel</a>
        </div>
    </form>
</div>
