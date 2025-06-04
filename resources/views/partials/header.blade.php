<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('favicon.ico')}}">
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <main class="flex-grow">
        <!-- Navigatie -->
        <nav class="bg-gray-800 shadow-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-between items-center h-16">
                    <div class="flex">
                        <a href="{{ route('home') }}" class="flex-shrink-0 text-2xl font-bold">
                            EventR
                        </a>
                        <div class="hidden md:block ml-10">
                            <div class="flex justify-between items-center w-full">
                                <div class="flex space-x-4">
                                    {{-- <a href="{{ route('dashboard') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">Your Dashboard</a> --}}
                                    <a href="{{ route('events') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('events') ? 'bg-gray-700' : '' }}">All Events</a>
                                    <a href="{{ route('user.events') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('user.events') ? 'bg-gray-700' : '' }}">Your Events</a>
                                    <a href="{{ route('user') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('user') ? 'bg-gray-700' : '' }}">Attending Events</a>
                                </div>

                            </div>
                            {{-- <div class="flex space-x-4">
                                <a href="{{ route('sighting') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('sighting') ? 'bg-gray-700' : '' }}">Nieuwe melding</a>
                                <a href="{{ route('sightings') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('sightings') ? 'bg-gray-700' : '' }}">Recente meldingen</a>
                                <a href="{{ route('about') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('about') ? 'bg-gray-700' : '' }}">Over Ons</a>
                                <a href="{{ route('contact') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md {{ request()->routeIs('contact') ? 'bg-gray-700' : '' }}">Contacteer Ons</a>
                            </div> --}}
                        </div>
                    </div>
                    @auth
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg">
                            Logout
                        </button>
                    </form>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>
            <div class="block md:hidden ml-10">
                {{-- <div class="flex space-x-4 flex-col">
                    <a href="{{ route('sightings') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">Recent</a>
                    <a href="{{ route('sightings') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">Archief</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-md">Over Ons</a>
                </div> --}}
            </div>
        </nav>
        @yield('content')
    </main>

@include('partials.footer')