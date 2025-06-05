@extends('partials.header')
@section('title', 'Your Events;')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Events I'm Attending</h1>
        <div class="space-y-6">
            @if ($events->isEmpty())
                <p class="text-center">You are not attending any events</p>
                <p class="text-center"><a href="{{ route('events') }}" class="text-violet-500 hover:underline">Find an event to attend</a></p>
            @endif
             @foreach ($events as $event)
                <div class="mb-2 border-b-2 border-gray-800 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                        <p>{{ $event->start_time }}</p>
                    </div>
                    <div>
                        <a
                            href="/user/events/{{ $event->id }}/unattend"
                            class="btn"
                            click="return confirm('are you sure?')"
                        >Unattend</a>
                    </div>
                </div>
             @endforeach
        </div>
    </div>
@endsection