@extends('partials.header')
@section('title', 'Your Events;')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Your events</h1>
        <div class="mb-6">
            <a href="{{ route('user.events.create') }}" class="btn btn-primary">Create Event</a>
        </div>
        <div class="space-y-6">
             @foreach ($events as $event)
                <div class="mb-2 border-b-2 border-gray-800 p-4">
                    <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                    <p>{{ $event->start_time }}</p>
                </div>
             @endforeach
        </div>
    </div>
@endsection