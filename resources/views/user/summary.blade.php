@extends('partials.header')
@section('title', 'EventR .:. Events I\'m hosting')

@section('content')
<div class="container mx-auto py-12 px-4 user-summary">
    <h1 class="text-3xl font-bold mb-8 text-center">Hello, {{ auth()->user()->name }}</h1>
    <div class="grid md:grid-cols-2 gap-8 overview">
        <div class="item bg-linear-to-br from-violet-800 via-violet-500 to-violet-400">
            <h2><span>{{ $hosting->count() }}</span> active hosting  {{ $hosting->count() === 1 ? 'event' : 'events' }}</h2>
            <p><a href="{{ route('user.events.hosting') }}" class="btn btn-primary">To my events</a></p>
        </div>
        <div class="item bg-linear-to-tr from-violet-400 via-violet-500 to-violet-800">
            <h2><span>{{ $hostingPast->count() }}</span> past hosting {{ $hostingPast->count() === 1 ? 'event' : 'events' }}</h2>
            <p><a href="{{ route('user.events.hosting.past') }}" class="btn btn-primary">To my events</a></p>
        </div>
        <div class="item bg-linear-to-tr from-violet-800 via-violet-500 to-violet-400">
            <h2><span>{{ $attending->count() }}</span> upcoming {{ $attending->count() === 1 ? 'event' : 'events' }} to attend</h2>
            <p><a href="{{ route('user.events.attending') }}" class="btn btn-primary">To my events</a></p>
        </div>
        <div class="item bg-linear-to-br from-violet-400 via-violet-500 to-violet-800">
            <h2><span>{{ $attendingPast->count() }}</span> attended {{ $attendingPast->count() === 1 ? 'event' : 'events' }}</h2>
            <p><a href="{{ route('user.events.attending.past') }}" class="btn btn-primary">To my events</a></p>
        </div>
    </div>
</div>
@endsection