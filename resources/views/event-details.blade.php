@extends('partials.header')
@section('title', $event->name)

@section('content')
    <div class="container mx-auto py-12 px-4">
        @livewire('display-event', ['eventId' => $event->id])
    </div>
@endsection