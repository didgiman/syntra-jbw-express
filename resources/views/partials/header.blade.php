<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('favicon.ico')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <main class="flex-grow">
        <!-- Navigatie -->
        <nav class="bg-gray-800 shadow-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 text-2xl font-bold">
                            EventR
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
                                    <li><a href="{{ route('user.summary') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user') ? 'bg-gray-700' : '' }}">My Events</a></li>
                                    <li><a href="" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">About EventR</a></li>
                                    <li><a href="" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">Contact Us</a></li>
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
                    <div class="bg-gray-700 shadow-lg mb-6 hidden md:block">
                        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                            <ul class="flex">
                                <li><a href="{{ route('user.events.hosting') }}" class="block text-gray-300 hover:bg-gray-800 px-3 py-2 {{ Str::contains(Route::currentRouteName(), 'user.events.hosting') ? 'bg-gray-800' : '' }}">Hosting</a></li>
                                <li><a href="{{ route('user.events.attending') }}" class="block text-gray-300 hover:bg-gray-800 px-3 py-2 {{ Str::contains(Route::currentRouteName(), 'user.events.attending') ? 'bg-gray-800' : '' }}">Attending</a></li>
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
                        <a href="{{ route('user.events.attending') }}" class="text-gray-300 hover:bg-gray-700 px-3 pl-6 py-2 rounded-md {{ Str::contains(Route::currentRouteName(), 'user.events.attending') ? 'text-violet-400' : '' }}"><i class="fa-solid fa-ticket mr-2"></i> Events I'm Attending</a>
                        <a href="" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">About EventR</a>
                        <a href="" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">Contact Us</a>
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
        @yield('content')
    </main>

@include('partials.footer')