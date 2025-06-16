@extends('partials.header')
@section('title', 'Edit an event')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Edit an event</h1>
        <div class="space-y-6">
             <livewire:edit-event :event="$event" />
        </div>
    </div>
@endsection