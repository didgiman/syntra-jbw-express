<div>
    <span class="text-xs bg-violet-500 text-white py-1 px-2 rounded absolute top-0 right-0 shadow uppercase">{{ $event->type->description }}</span>
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