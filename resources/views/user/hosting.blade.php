@extends('partials.header')
@section('title', 'EventR .:. Events I\'m hosting')

@section('content')
    <div class="container mx-auto py-12 px-4">

        @switch($view)
            @case('hosting')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I'm Hosting</h1>
                <div class="mb-6 flex justify-center">
                    <a href="{{ route('user.events.hosting.create') }}" class="btn btn-primary block w-full md:w-1/3">Create Event</a>
                </div>
            @break
            
            @case('hosting.past')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I've hosted in the past</h1>
                <p class="text-center"><a href="{{ route('user.events.hosting') }}" class="text-violet-500 hover:underline">Back to active events</a></p>
            @break
            
            @default
            {{-- Other routes --}}
        @endswitch
        
        @if (session('message'))
            <div class="text-green-500 font-bold text-xl text-center mb-4">
                {{ session('message') }}
            </div>
        @endif
            
        @livewire('list-user-events', ['view' => $view])

        @if ($view !== 'hosting.past')
            <p class="text-center mt-12"><a href="{{ route('user.events.hosting.past') }}" class="text-violet-500 hover:underline">See past events</a></p>
        @endif
    </div>
@endsection