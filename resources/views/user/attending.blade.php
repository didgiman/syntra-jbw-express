@extends('partials.header')
@section('title', 'EventR .:. Events I\'m Attending')

{{-- load the countdown script --}}
@push('scripts')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endpush

@section('content')
    <div class="container mx-auto py-12 px-4">
        @switch($view)
            @case('attending')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I'm Attending</h1>
            @break
            
            @case('attending.past')
                <h1 class="text-3xl font-bold mb-8 text-center">Events I've attended in the past</h1>
                <p class="text-center"><a href="{{ route('user.events.attending') }}" class="text-violet-500 hover:underline">Back to active events</a></p>
            @break
            
            @default
            {{-- Other routes --}}
        @endswitch
        
        @livewire('list-user-events', ['view' => $view])

        @if ($view !== 'attending.past')
            <p class="text-center mt-12"><a href="{{ route('user.events.attending.past') }}" class="text-violet-500 hover:underline">See past events</a></p>
        @endif
    </div>
@endsection