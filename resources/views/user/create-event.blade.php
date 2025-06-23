@extends('partials.header')
@section('title', 'Create new event')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@latest/es2021/jodit.fat.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jodit@latest/es2021/jodit.fat.min.js"></script>
@endpush

@section('content')
    <div class="container mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Create new event</h1>
        <div class="space-y-6">
             @livewire('create-event')
        </div>
    </div>
@endsection