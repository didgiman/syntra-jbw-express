<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventR</title>
    @vite('resources/css/app.css')

</head>
<body>
    <header>
    {{-- This code block handles what the user sees. If they're a guest they'll see: login / register.
    If they're authenticated, they'll see: dashboard instead. --}}
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <h1 class="text-3xl font-bold underline">
    If this is styled, tailwinds works.
  </h1>
</body>
</html>