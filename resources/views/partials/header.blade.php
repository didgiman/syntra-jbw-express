<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include Jodit CSS Styling -->
    {{-- <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">

    <!-- Include the Jodit JS Library -->
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@latest/es2021/jodit.fat.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jodit@latest/es2021/jodit.fat.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <!-- Navigatie -->
    <nav class="bg-gray-800 shadow-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex gap-2">
                        <img src="{{asset('logo.png')}}" class="w-10">
                        <div class="text-2xl font-bold tracking-wider"><span class="text-violet-500">E</span>vent<span class="text-[#46b2fd]">R</span></div>
                    </a>
                    <div class="hidden md:block ml-10">
                        <div class="flex justify-between items-center w-full">
                            {{-- <div class="flex space-x-4">
                                <a href="{{ route('events') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('events') ? 'bg-gray-700' : '' }}">All Events</a>
                                @auth
                                    <a href="{{ route('user.summary') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('user.summary') ? 'bg-gray-700' : '' }}">My Events</a>
                                    <a href="{{ route('user.events.hosting') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.events.hosting') ? 'bg-gray-700' : '' }}">Events I'm Hosting</a>
                                    <a href="{{ route('user.events.attending') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.events.attending') ? 'bg-gray-700' : '' }}">Events I'm Attending</a>
                                @endauth
                            </div> --}}

                            <ul class="flex space-x-4">
                                <li><a href="{{ route('events') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('events') ? 'bg-gray-700' : '' }}">All Events</a></li>
                                <li><a href="{{ route('user.summary') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user') ? 'bg-gray-700' : '' }}">My EventR</a></li>
                                <li><a href="{{ route('about') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'about') ? 'bg-gray-700' : '' }}">About EventR</a></li>
                                <li><a href="{{ route('contact') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'contact') ? 'bg-gray-700' : '' }}">Contact Us</a></li>
                            </ul>

                        </div>
                    </div>

                </div>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        Logout
                    </button>
                </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login hidden md:block">Login</a>
                @endauth

                <button id="hamburger" class="text-white text-xl md:hidden flex items-center mr-6" aria-label="Navigatie menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        @auth
            @if (Str::contains(Route::currentRouteName(), 'user'))
                <div class="bg-gray-700 shadow-lg hidden md:block">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                        <ul class="flex">
                            <li><a href="{{ route('user.events.hosting') }}" class="block text-gray-300 hover:bg-gray-800 px-3 py-2 {{ Str::contains(Route::currentRouteName(), 'user.events.hosting') ? 'bg-gray-800' : '' }}"><i class="fa-solid fa-web-awesome mr-2"></i>Hosting</a></li>
                            <li><a href="{{ route('user.events.attending') }}" class="block text-gray-300 hover:bg-gray-800 px-3 py-2 {{ Str::contains(Route::currentRouteName(), 'user.events.attending') ? 'bg-gray-800' : '' }}"><i class="fa-solid fa-ticket mr-2"></i>Attending</a></li>
                            <li><a href="{{ route('user.settings') }}" class="block text-gray-300 hover:bg-gray-800 px-3 py-2 {{ Str::contains(Route::currentRouteName(), 'user.settings') ? 'bg-gray-800' : '' }}"><i class="fa-solid fa-gear mr-2"></i>Settings</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        @endauth
            
        {{-- Mobile navigation --}}
        <div class="md:hidden text-white space-y-2 overflow-hidden opacity-0 max-h-0" id="mobile-menu">
            <div class="flex flex-col space-y-4 pb-4">
                <a href="{{ route('events') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('events') ? 'text-violet-400' : '' }}">All Events</a>
                
                @auth
                    <a href="{{ route('user.summary') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('user.summary') ? 'text-violet-400' : '' }}">My Events</a>
                    <a href="{{ route('user.events.hosting') }}" class="text-gray-300 hover:bg-gray-700 px-3 pl-6 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.events.hosting') ? 'text-violet-400' : '' }}"><i class="fa-solid fa-web-awesome mr-2"></i>Events I'm Hosting</a>
                    <a href="{{ route('user.events.attending') }}" class="text-gray-300 hover:bg-gray-700 px-3 pl-6 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.events.attending') ? 'text-violet-400' : '' }}"><i class="fa-solid fa-ticket mr-2"></i>Events I'm Attending</a>
                    <a href="{{ route('user.settings') }}" class="text-gray-300 hover:bg-gray-700 px-3 pl-6 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.settings') ? 'text-violet-400' : '' }}"><i class="fa-solid fa-gear mr-2"></i>My Settings</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'about') ? 'bg-gray-700' : '' }}">About EventR</a>
                    <a href="{{ route('contact') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'contact') ? 'bg-gray-700' : '' }}">Contact Us</a>
                    <form method="POST" action="{{ route('logout') }}" class="flex justify-center">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            Logout
                        </button>
                    </form>
                @else
                    <div class="flex justify-center">
                        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Add a stack for scripts --}}
    @stack('scripts')
</body>

</html>
