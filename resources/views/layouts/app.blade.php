<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'EventR' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex flex-col">
    <header>
        <nav>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('all_events') }}">All events</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer>
        <p class="text-center text-gray-500 text-xs">&copy; {{ date('Y') }} EventR. All rights reserved.</p>
    </footer>
</body>
</html>