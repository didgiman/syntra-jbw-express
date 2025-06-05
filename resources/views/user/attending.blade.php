@extends('partials.header')
@section('title', 'Your Events;')

@section('content')
    <div class="container mx-auto py-12 px-4">
        @switch(Route::currentRouteName())
            @case('user.events.attending')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I'm Attending</h1>
            @break
            
            @case('user.events.attending.past')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I've attended in the past</h1>
                <p class="text-center"><a href="{{ route('user.events.attending') }}" class="text-violet-500 hover:underline">Back to active events</a></p>
            @break
            
            @default
            {{-- Other routes --}}
        @endswitch
        
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
                    @if (Route::currentRouteName() !== 'user.events.attending.past')
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

        @if (Route::currentRouteName() !== 'user.events.attending.past')
            <p class="text-center mt-12"><a href="{{ route('user.events.attending.past') }}" class="text-violet-500 hover:underline">See past events</a></p>
        @endif
    </div>
@endsection