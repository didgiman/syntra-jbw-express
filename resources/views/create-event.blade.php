@extends('partials.header')
@section('title', 'Create new event')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Create a new event</h1>
        <div class="space-y-6">
             @livewire('create-event')
        </div>
    </div>
@endsection