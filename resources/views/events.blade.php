@extends('partials.header')
@section('title', 'Events')

{{-- load the countdown script --}}
@push('scripts')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endpush

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">All events</h1>
        <div class="space-y-6">
        @livewire('event-list')
        </div>
    </div>

@endsection