@extends('partials.header')
@section('title', 'EventR Home')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Upcoming Events</h2>
            <ul>
                @forelse($upcomingEvents as $event)
                    <li class="mb-2 p-4 border rounded shadow">
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
    </div>
@endsection