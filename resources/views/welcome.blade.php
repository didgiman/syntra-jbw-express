@extends('partials.header')
@section('title', 'EventR Home')

@section('content')
    <div x-data="{ open: false, selectedEvent: null }" class="container mx-auto py-12 px-4">
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Upcoming Events</h2>
            <ul>
                @forelse($upcomingEvents as $event)
                    <li 
                        class="mb-2 p-4 border rounded shadow cursor-pointer hover:bg-black"
                        @click="open = true; selectedEvent = {{ $event->toJson() }}"
                    >
                        <div class="font-bold">{{ $event->name }}</div>
                        <div class="text-gray-600 text-sm">
                            Starts: {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                        </div>
                        <div>{{ $event->description }}</div>
                    </li>
                @empty
                    <li>No upcoming events.</li>
                @endforelse
            </ul>
        </section>

        <!-- Modal -->
        <div 
            x-show="open" 
            style="display: none;" 
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
            <div class="bg-black rounded-lg shadow-lg max-w-md w-full p-6 relative">
                <button 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                    @click="open = false"
                >&times;</button>
                <template x-if="selectedEvent">
                    <div>
                        <h3 class="text-xl font-bold mb-2" x-text="selectedEvent.name"></h3>
                        <div class="text-gray-600 mb-2" x-text="'Starts: ' + new Date(selectedEvent.start_time).toLocaleString()"></div>
                        <div class="mb-4" x-text="selectedEvent.description"></div>
                        <div class="mb-4" x-text="'Location: ' + (selectedEvent.location ?? 'TBA')"></div>
                        <button 
                            class="fixed bottom-8 right-8 bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700"
                            @click="alert('You are attending ' + selectedEvent.name); open = false;"
                        >
                            Attend
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection