@extends('partials.header')
@section('title', 'Your Events;')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Your events</h1>
        <div class="mb-6 flex justify-center">
            <a href="{{ route('user.events.create') }}" class="btn btn-primary block w-full md:w-1/3">Create Event</a>
        </div>
        <div class="space-y-6">
             @foreach ($events as $event)
                <div class="mb-2 border-b-2 border-gray-800 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                        <p>{{ $event->start_time }}</p>
                    </div>
                    <div>
                        <a
                            href="/user/events/{{ $event->id }}/edit"
                            wire:navigate
                        >Edit</a>
                    </div>
                </div>
             @endforeach
        </div>
    </div>
@endsection