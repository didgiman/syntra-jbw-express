@extends('partials.header')
@section('title', 'EventR Home')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Hero Section with Branding - Directly below navigation header --}}
        <section class="mb-12">
            <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl overflow-hidden">
                <div class="flex flex-col md:flex-row items-center">
                    {{-- Logo and Branding --}}
                    <div class="md:w-1/3 p-8 flex justify-center">
                        <img src="{{ asset('logo.png') }}" alt="EventR Logo" class="w-48 md:w-64 h-auto">
                    </div>
                    
                    {{-- Welcome Text --}}
                    <div class="md:w-2/3 p-8 md:pl-0">
                        <h1 class="text-3xl md:text-4xl font-bold mb-4 flex items-center">
                            <span class="text-violet-500">E</span><span class="text-white">vent</span><span class="text-blue-500">R</span>
                        </h1>
                        <p class="text-gray-300 text-lg mb-6">
                            Your premier destination for discovering, creating, and managing events that matter. 
                            From conferences to concerts, workshops to weddings - we've got you covered.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-md shadow-md transition-colors duration-200">
                                Get Started
                            </a>
                            <a href="{{ route('events') }}" class="px-6 py-3 border border-blue-500 text-blue-400 hover:bg-blue-900 hover:bg-opacity-30 font-medium rounded-md shadow-md transition-colors duration-200">
                                Explore Events
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Feature Highlights --}}
                <div class="bg-black bg-opacity-50 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="text-violet-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">Easy Registration</h3>
                                <p class="text-gray-400 text-sm">Sign up in seconds and start managing your events</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">Real-time Updates</h3>
                                <p class="text-gray-400 text-sm">Get instant notifications about event changes</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">Community Experience</h3>
                                <p class="text-gray-400 text-sm">Connect with others who share your interests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Carousel Section for Upcoming Events --}}
        <section class="mb-8" x-data="{ 
            currentIndex: 0,
            events: {{ json_encode($upcomingEvents->take(6)->values()) }},
            eventTypes: {{ json_encode($upcomingEvents->take(6)->map(function($event) { return $event->type; })) }},
            autoplayEnabled: true,
            autoplaySpeed: 8000, // 8 seconds between slides
            autoplayTimer: null,
            countdownTimer: null,
            
            calculateTimeLeft(futureDate) {
                const future = new Date(futureDate).getTime();
                const now = new Date().getTime();
                const diff = future - now;
                
                if (diff <= 0) {
                    return 'Event has started';
                }
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                let timeString = '';
                if (days > 0) timeString += days + ' days ';
                if (hours > 0) timeString += hours + ' hours ';
                if (minutes > 0) timeString += minutes + ' min ';
                timeString += seconds + ' sec';
                
                return timeString;
            },
            
            startCountdown() {
                // Update countdown every second
                this.countdownTimer = setInterval(() => {
                    // Force Alpine to re-evaluate the countdown
                    this.currentTime = Date.now();
                }, 1000);
            },
            
            stopCountdown() {
                if (this.countdownTimer) {
                    clearInterval(this.countdownTimer);
                    this.countdownTimer = null;
                }
            },
            
            get totalEvents() { return this.events.length },
            
            startAutoplay() {
                if (this.autoplayEnabled && this.totalEvents > 1) {
                    this.autoplayTimer = setInterval(() => {
                        if (document.visibilityState === 'visible') {
                            this.next();
                        }
                    }, this.autoplaySpeed);
                }
            },
            
            stopAutoplay() {
                if (this.autoplayTimer) {
                    clearInterval(this.autoplayTimer);
                    this.autoplayTimer = null;
                }
            },
            
            toggleAutoplay() {
                this.autoplayEnabled = !this.autoplayEnabled;
                if (this.autoplayEnabled) {
                    this.startAutoplay();
                } else {
                    this.stopAutoplay();
                }
            },
            
            next() { 
                this.currentIndex = (this.currentIndex + 1) % this.totalEvents;
            },
            
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.totalEvents) % this.totalEvents;
            },
            
            isActive(index) {
                return this.currentIndex === index;
            },
            
            isPrev(index) {
                return (this.currentIndex - 1 + this.totalEvents) % this.totalEvents === index;
            },
            
            isNext(index) {
                return (this.currentIndex + 1) % this.totalEvents === index;
            }
        }" 
        x-init="startAutoplay(); startCountdown();"
        @mouseenter="stopAutoplay()"
        @mouseleave="if(autoplayEnabled) startAutoplay()"
        @visibilitychange.window="document.visibilityState === 'visible' ? (autoplayEnabled ? startAutoplay() : null) : stopAutoplay()"
        >
            <h2 class="text-2xl font-semibold mb-4">Upcoming Events</h2>
            
            {{-- Carousel Container --}}
            <div class="relative py-10">
                {{-- Carousel Navigation --}}
                <button 
                    @click="prev()" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-3 rounded-full shadow-lg"
                    :disabled="totalEvents <= 1"
                    :class="{ 'opacity-50 cursor-not-allowed': totalEvents <= 1 }"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <button 
                    @click="next()" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-3 rounded-full shadow-lg"
                    :disabled="totalEvents <= 1"
                    :class="{ 'opacity-50 cursor-not-allowed': totalEvents <= 1 }"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                {{-- Carousel Track --}}
                <div class="flex justify-center items-center h-[450px] overflow-hidden">
                    {{-- Empty State --}}
                    <template x-if="totalEvents === 0">
                        <div class="text-gray-500 text-center py-4">No upcoming events.</div>
                    </template>
                    
                    {{-- Event Cards --}}
                    <template x-for="(event, index) in events" :key="event.id">
                        <div 
                            class="absolute transition-all duration-500 w-full max-w-md mx-2"
                            :class="{
                                'z-30 scale-100 opacity-100': isActive(index),
                                'z-20 -translate-x-2/3 scale-90 opacity-70': isPrev(index),
                                'z-20 translate-x-2/3 scale-90 opacity-70': isNext(index),
                                'z-10 opacity-0 scale-75': !isActive(index) && !isPrev(index) && !isNext(index)
                            }"
                        >
                            <div 
                                class="bg-black border rounded-lg shadow-lg p-4 relative h-full transition-all duration-200 hover:shadow-purple-500/30 hover:shadow-lg"
                                :class="isActive(index) ? 'cursor-pointer' : 'cursor-default'"
                                @click="if(isActive(index)) { window.location.href = '/events/' + event.id }"
                            >
                                {{-- Event Type Badge --}}
                                <span 
                                    class="text-xs text-white py-1 px-2 rounded absolute -top-2 shadow uppercase -left-2 z-10"
                                    :style="{ backgroundColor: eventTypes[index] ? eventTypes[index].color : '#6D28D9' }"
                                    x-text="eventTypes[index] ? eventTypes[index].description : 'NO TYPE'"
                                ></span>

                                {{-- Event Image --}}
                                <div class="mb-4">
                                    <img 
                                        :src="event.image"
                                        :alt="event.name + ' poster'" 
                                        class="w-full h-48 object-cover rounded-lg"
                                        onerror="this.src='https://via.placeholder.com/400x225?text=No+Image'"
                                    >
                                </div>

                                {{-- Event Details --}}
                                <div class="space-y-2">
                                    {{-- Event Name --}}
                                    <h3 class="font-bold text-lg" x-text="event.name"></h3>
                                    
                                    {{-- Start Time --}}
                                    <div class="text-red-300 text-sm font-bold">
                                        <span x-text="'Starts: ' + new Date(event.start_time).toLocaleDateString() + ' ' + new Date(event.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                                    </div>

                                    {{-- Countdown --}}
                                    <div class="text-yellow-300 text-sm" 
                                         x-data="{
                                            timeLeft: '',
                                            updateCountdown() {
                                                const future = new Date(event.start_time).getTime();
                                                const now = new Date().getTime();
                                                const diff = future - now;
                                                
                                                if (diff <= 0) {
                                                    this.timeLeft = 'Event has started';
                                                    return;
                                                }
                                                
                                                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                                                
                                                let timeString = '';
                                                if (days > 0) timeString += days + ' days ';
                                                if (hours > 0) timeString += hours + ' hrs ';
                                                if (minutes > 0) timeString += minutes + ' min ';
                                                timeString += seconds + ' sec';
                                                
                                                this.timeLeft = 'Starts in: ' + timeString;
                                            }
                                        }"
                                        x-init="updateCountdown(); setInterval(() => updateCountdown(), 1000)"
                                        x-text="timeLeft">
                                    </div>

                                    {{-- Price/Free Badge --}}
                                    <div class="mt-2">
                                        <template x-if="event.price == 0">
                                            <span class="inline-block text-xs text-white py-1 px-2 rounded shadow uppercase font-bold bg-violet-600">
                                                FREE
                                            </span>
                                        </template>
                                        <template x-if="event.price > 0">
                                            <span class="text-yellow-400 font-semibold" x-text="'€' + event.price"></span>
                                        </template>
                                    </div>
                                    
                                    {{-- Availability Status --}}
                                    <div class="mt-2">
                                        <template x-if="event.max_attendees === null">
                                            <span class="text-blue-400 font-semibold">Unlimited spots</span>
                                        </template>
                                        <template x-if="event.max_attendees !== null">
                                            <template x-if="(event.max_attendees - event.attendees.length) <= 0">
                                                <span class="text-red-600 font-semibold">SOLD OUT</span>
                                            </template>
                                            <template x-if="(event.max_attendees - event.attendees.length) > 0">
                                                <span class="text-green-400 font-semibold" x-text="(event.max_attendees - event.attendees.length) + ' spots left'"></span>
                                            </template>
                                        </template>
                                    </div>
                                    
                                    {{-- Subtle "Click for details" hint for active card --}}
                                    <div class="mt-3 text-center text-violet-400/80 text-xs" x-show="isActive(index)">
                                        Click for details
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                {{-- Carousel Indicators --}}
                <div class="flex justify-center mt-4">
                    <template x-for="(event, index) in events" :key="'dot-'+index">
                        <button 
                            @click="currentIndex = index"
                            class="w-3 h-3 mx-1 rounded-full transition-colors duration-200"
                            :class="isActive(index) ? 'bg-violet-600' : 'bg-gray-400 hover:bg-gray-600'"
                            :aria-label="'Go to slide ' + (index + 1)"
                        ></button>
                    </template>
                </div>
            </div>
        </section>

        {{-- View All Events Button --}}
        <div class="text-center my-8">
            <a href="{{ route('events') }}" class="inline-flex items-center justify-center px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-md shadow-md transition-colors duration-200 group">
                <span>View All Events</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        {{-- Statistics Section --}}
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-6">EventR at a Glance</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Events Stat --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Total Events</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['eventCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">Events hosted on our platform</p>
                </div>
                
                {{-- Active Users Stat --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Active Users</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['userCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">People organizing and attending events</p>
                </div>
                
                {{-- Upcoming Events Stat --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Upcoming Events</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['upcomingCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">Events scheduled for the future</p>
                </div>
            </div>
        </section>

        {{-- Additional Statistics Section --}}
        <section class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Event Registrations --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Event Registrations</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['registrationCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">Total event registrations</p>
                </div>
                
                {{-- Free Events --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Free Events</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['freeEventCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">Events available at no cost</p>
                </div>
                
                {{-- Types of Events --}}
                <div class="bg-gradient-to-tr from-violet-800 via-violet-500 to-violet-400 rounded shadow p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-80">Event Categories</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['typeCount'] }}</p>
                        </div>
                        <div class="text-white/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm opacity-80">Different types of events available</p>
                </div>
            </div>
        </section>

        {{-- Event Details Modal --}}
        <div 
            x-show="open" 
            style="display: none;" 
            class="fixed inset-0 overflow-hidden z-50"
            @keydown.escape.window="open = false"
            x-init="$watch('open', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            })"
        >
            {{-- Modal Backdrop --}}
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" 
                @click="open = false">
            </div>
            
            {{-- Modal Container --}}
            <div class="fixed inset-0 flex items-center justify-center pointer-events-none overflow-y-auto">
                {{-- Modal Content --}}
                <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-4xl my-8 mx-auto relative text-white pointer-events-auto">
                    {{-- Close Button --}}
                    <button 
                        class="absolute top-4 right-4 text-gray-400 hover:text-white z-10 flex items-center gap-2"
                        @click="open = false"
                    >
                        <span class="text-sm font-medium">Close</span>
                        <span class="text-2xl">&times;</span>
                    </button>

                    {{-- Event Content - Mimicking display-event.blade.php --}}
                    <template x-if="selectedEvent">
                        <div class="p-6">
                            {{-- Header with Event Title --}}
                            <div class="mb-8">
                                <h1 class="text-3xl font-bold text-center" x-text="selectedEvent.name"></h1>
                            </div>

                            {{-- Main Content Grid --}}
                            <div class="grid md:grid-cols-2 gap-8">
                                {{-- Left Column: Event Details --}}
                                <div class="space-y-6">
                                    {{-- Time Section --}}
                                    <div class="bg-gray-800 p-6 rounded-lg">
                                        <div class="space-y-2">
                                            <p>
                                                <b class="text-gray-400">Starts:</b> 
                                                <span class="text-green-500 block text-lg" 
                                                      x-text="new Date(selectedEvent.start_time).toLocaleString()">
                                                </span>
                                            </p>
                                            <p>
                                                <b class="text-gray-400">Ends:</b> 
                                                <span class="text-red-500 block text-lg"
                                                      x-text="new Date(selectedEvent.end_time).toLocaleString()">
                                                </span>
                                            </p>
                                        </div>

                                        {{-- Status/Countdown --}}
                                        <div class="mt-4 p-3 bg-gray-700 rounded"
                                            x-data="{
                                                timeLeft: '',
                                                updateCountdown() {
                                                    const future = new Date(selectedEvent.start_time).getTime();
                                                    const now = new Date().getTime();
                                                    const diff = future - now;
                                                    
                                                    if (diff <= 0) {
                                                        this.timeLeft = 'Event has started';
                                                        return;
                                                    }
                                                    
                                                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                                                    
                                                    let timeString = '';
                                                    if (days > 0) timeString += days + ' days ';
                                                    if (hours > 0) timeString += hours + ' hrs ';
                                                    if (minutes > 0) timeString += minutes + ' min ';
                                                    timeString += seconds + ' sec';
                                                    
                                                    this.timeLeft = 'Time until event starts: ' + timeString;
                                                }
                                            }"
                                            x-init="updateCountdown(); setInterval(() => updateCountdown(), 1000)"
                                        >
                                            <div class="text-yellow-300 font-semibold" x-text="timeLeft">&nbsp;</div>
                                        </div>
                                    </div>

                                    {{-- Location Section --}}
                                    <div class="bg-gray-800 p-6 rounded-lg">
                                        <h2 class="text-lg font-semibold mb-3">Location</h2>
                                        <template x-if="selectedEvent.location">
                                            <a :href="'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(selectedEvent.location)"
                                               class="text-blue-400 hover:text-blue-300 hover:underline flex items-center gap-2"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                                </svg>
                                                <span x-text="selectedEvent.location"></span>
                                            </a>
                                        </template>
                                        <template x-if="!selectedEvent.location">
                                            <span class="text-gray-400">Location: TBA</span>
                                        </template>
                                    </div>

                                    {{-- Description Section --}}
                                    <template x-if="selectedEvent.description">
                                        <div class="bg-gray-800 p-6 rounded-lg">
                                            <h2 class="text-lg font-semibold mb-3">About this Event</h2>
                                            <div class="text-gray-300" x-text="selectedEvent.description"></div>
                                        </div>
                                    </template>

                                    {{-- Actions Section --}}
                                    <div class="bg-gray-800 p-6 rounded-lg">
                                        {{-- Availability Status --}}
                                        <div class="mb-4">
                                            <template x-if="selectedEvent.max_attendees === null">
                                                <p class="text-blue-400">
                                                    <span x-text="selectedEvent.attendees ? selectedEvent.attendees.length : 0"></span> attending - Unlimited spots available
                                                </p>
                                            </template>
                                            <template x-if="selectedEvent.max_attendees !== null">
                                                <p class="text-sm" :class="selectedEvent.remaining_spots > 0 ? 'text-blue-400' : 'text-red-500 font-bold text-base'">
                                                    <span x-text="selectedEvent.attendees ? selectedEvent.attendees.length : 0"></span> attending - 
                                                    <template x-if="selectedEvent.remaining_spots <= 0">
                                                        <span>SOLD OUT</span>
                                                    </template>
                                                    <template x-if="selectedEvent.remaining_spots > 0">
                                                        <span x-text="selectedEvent.remaining_spots + ' spots remaining'"></span>
                                                    </template>
                                                </p>
                                            </template>
                                        </div>

                                        {{-- Action Button --}}
                                        <template x-if="selectedEvent.remaining_spots > 0 || selectedEvent.max_attendees === null">
                                            <a :href="'/events/' + selectedEvent.id" class="btn btn-primary w-full text-center block py-2 px-4 bg-violet-600 hover:bg-violet-700 rounded font-medium">
                                                View Event Details
                                            </a>
                                        </template>
                                        <template x-if="selectedEvent.remaining_spots <= 0 && selectedEvent.max_attendees !== null">
                                            <div class="text-red-500 text-center font-bold">
                                                SOLD OUT
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- Right Column: Image and Price --}}
                                <div>
                                    {{-- Image Container --}}
                                    <div class="relative mb-6">
                                        {{-- Event Type Badge --}}
                                        <span 
                                            class="text-xs text-white py-1 px-2 rounded absolute -top-2 shadow uppercase -left-2 md:-left-4 z-10"
                                            :style="{ backgroundColor: selectedEvent.type ? selectedEvent.type.color : '#6D28D9' }"
                                            x-text="selectedEvent.type_name">
                                        </span>

                                        <template x-if="selectedEvent.image">
                                            <img :src="selectedEvent.image"
                                                 :alt="selectedEvent.name"
                                                 class="w-full h-[400px] object-cover rounded-lg shadow-lg">
                                        </template>
                                    </div>

                                    {{-- Price Section --}}
                                    <div class="bg-gray-800 p-6 rounded-lg">
                                        <h2 class="text-lg font-semibold mb-3">Ticket Price</h2>
                                        
                                        <div x-data="{ 
                                            currentCurrency: 'EUR',
                                            exchangeRates: {
                                                'EUR': 1,
                                                'USD': 1.08,
                                                'GBP': 0.86,
                                                'JPY': 161.5
                                            },
                                            symbols: {
                                                'EUR': '€',
                                                'USD': '$',
                                                'GBP': '£',
                                                'JPY': '¥'
                                            },
                                            get convertedPrice() {
                                                return (selectedEvent.price || 0) * this.exchangeRates[this.currentCurrency];
                                            },
                                            formatPrice(price) {
                                                if (this.currentCurrency === 'JPY') {
                                                    return Math.round(price);
                                                }
                                                return price.toFixed(2);
                                            }
                                        }">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <template x-if="selectedEvent.price == 0">
                                                        <span class="text-violet-600 font-bold text-xl">FREE</span>
                                                    </template>
                                                    <template x-if="selectedEvent.price > 0">
                                                        <span class="text-yellow-400 font-bold text-xl">
                                                            <span x-text="symbols[currentCurrency]"></span>
                                                            <span x-text="formatPrice(convertedPrice)"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                                
                                                <template x-if="selectedEvent.price > 0">
                                                    <div class="flex space-x-2">
                                                        <template x-for="currency in ['EUR', 'USD', 'GBP', 'JPY']">
                                                            <button 
                                                                @click="currentCurrency = currency"
                                                                :class="{'bg-blue-600': currentCurrency === currency, 'bg-gray-700': currentCurrency !== currency}"
                                                                class="px-2 py-1 rounded text-sm font-semibold transition-colors duration-150"
                                                                x-text="currency"
                                                            ></button>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
    function calculateTimeLeft(futureDate) {
        const future = new Date(futureDate).getTime();
        const now = new Date().getTime();
        const diff = future - now;
        
        if (diff <= 0) {
            return "Event has started";
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        let timeString = "";
        if (days > 0) timeString += days + " days ";
        if (hours > 0) timeString += hours + " hours ";
        timeString += minutes + " minutes";
        
        return timeString;
    }
</script>
@endpush