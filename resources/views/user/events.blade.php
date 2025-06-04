@extends('partials.header')
@section('title', 'Your Events;')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Your events</h1>
        <div class="mb-6 flex justify-center">
            <a href="{{ route('user.events.create') }}" class="btn btn-primary block w-full md:w-1/3">Create Event</a>
        </div>
        <div class="space-y-6">

            @if (session('message'))
                <div class="text-green-500 font-bold text-xl text-center">
                    {{ session('message') }}
                </div>
            @endif

             @foreach ($events as $event)
                <div class="mb-2 border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
                    <div class="flex gap-4">
                        <div class="w-20 flex justify-center">
                            <img src="{{ $event->image }}" class="">
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                            <p><span class="text-sm font-semibold text-violet-400">{{ $event->type->description }}</span> {{ $event->start_time }}</p>
                        </div>
                    </div>
                    <div>
                        <a
                            href="/user/events/{{ $event->id }}/edit"
                            wire:navigate
                            class="underline"
                        >Edit</a>
                    </div>
                </div>
             @endforeach
        </div>
    </div>
@endsection