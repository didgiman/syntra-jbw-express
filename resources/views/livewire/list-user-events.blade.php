<div class="space-y-2">

    @if ($message)
        <div class="text-green-500 font-bold text-xl text-center">
            {{ $message }}
        </div>
    @endif

    @if ($events->isEmpty())
        <div class="space-y-4">
        @switch ($view)
            @case('attending')
                <p class="text-center">You are not attending any events</p>
                <p class="text-center"><a href="{{ route('events') }}" class="text-violet-500 hover:underline">Find an event to attend</a></p>
            @break
            @case('attending.past')
                <p class="text-center">You have not attended any events</p>
                <p class="text-center"><a href="{{ route('events') }}" class="text-violet-500 hover:underline">Find an event to attend</a></p>
            @break
            @case('hosting')
                <p class="text-center">You are not hosting any events</p>
            @break
            @case('hosting.past')
                <p class="text-center">You have not hosted any events</p>
            @break
        @endswitch
        </div>
    @endif

    @foreach ($events as $event)
        <div class="relative border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
            
            <div>
                <span class="text-xs bg-violet-500 text-white py-1 px-2 rounded absolute top-0 shadow uppercase -left-2 md:-left-4">{{ $event->type->description }}</span>
                <div class="flex gap-4">
                    <div class="w-20 flex justify-center">
                        <img src="{{ $event->image }}" class="w-20 min-w-20 h-20 object-cover rounded-lg">
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                        <p>{{ $event->start_time->format('l, F jS Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if ($view === 'hosting')
                <div class="flex flex-col gap-2">
                    <a
                        href="{{ route('user.events.hosting.edit', ['event' => $event->id]) }}"
                        wire:navigate
                        class="underline"
                    >Edit</a>

                    <button class="text-red-500 hover:text-red-700 cursor-pointer underline"
                        wire:click="delete({{ $event->id }})"
                        wire:confirm="Are you sure?">Delete</button>
                </div>
            @elseif ($view === 'attending')
                <div>
                    <a
                        href="/user/events/{{ $event->id }}/unattend"
                        class="btn"
                        click="return confirm('are you sure?')"
                    >Unattend</a>
                </div>
            @endif
        </div>
    @endforeach
</div>
