@extends('partials.header')
@section('title', 'Events I\'m hosting')

@section('content')
    <div class="container mx-auto py-12 px-4">

        @switch(Route::currentRouteName())
            @case('user.events.hosting')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I'm Hosting</h1>
                <div class="mb-6 flex justify-center">
                    <a href="{{ route('user.events.hosting.create') }}" class="btn btn-primary block w-full md:w-1/3">Create Event</a>
                </div>
            @break
            
            @case('user.events.hosting.past')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I've hosted in the past</h1>
                <p class="text-center"><a href="{{ route('user.events.hosting') }}" class="text-violet-500 hover:underline">Back to active events</a></p>
            @break
            
            @default
            {{-- Other routes --}}
        @endswitch
            
        <div class="space-y-6">
            @if (session('message'))
                <div class="text-green-500 font-bold text-xl text-center">
                    {{ session('message') }}
                </div>
            @endif

             @foreach ($events as $event)
                <div class="relative mb-2 border-b-2 border-gray-800 py-4 flex justify-between items-center {{ session('highlight-event') === $event->id ? 'bg-green-900 p-4 rounded-lg' : '' }}">
                    
                    @include('partials.user.event-list-item', ['event' => $event])

                    @if (Route::currentRouteName() !== 'user.events.hosting.past')
                        <div>
                            <a
                                href="{{ route('user.events.hosting.edit', ['event' => $event->id]) }}"
                                wire:navigate
                                class="underline"
                            >Edit</a>
                        </div>
                    @endif
                </div>
             @endforeach
        </div>

        @if (Route::currentRouteName() !== 'user.events.hosting.past')
            <p class="text-center mt-12"><a href="{{ route('user.events.hosting.past') }}" class="text-violet-500 hover:underline">See past events</a></p>
        @endif
    </div>
@endsection