<?php

use App\Livewire\CreateEvent;
use App\Livewire\Dashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // grab the earliest upcoming events from the DB
    $upcomingEvents = Event::where('start_time', '>=', now())
        ->orderBy('start_time')
        ->take(6)
        ->get();
    return view('welcome', compact('upcomingEvents'));
})->name('home');

Route::get('/events', function() {
    return view('events');
})->name('events');

Route::middleware(['auth'])->group(function () {

    Route::get('/user', function() {
        $events = Event::whereHas('attendees', function($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('start_time', 'DESC')->get();
        return view('user.attendees', ['events' => $events]);
    })->name('user');

    Route::get('/user/events', function() {
        $events = Event::where('user_id', Auth::user()->id)->orderby('start_time', 'DESC')->get();
        return view('user.events', ['events' => $events]);
    })->name('user.events');

    Route::get('/user/events/create', function() {
        return view('user.create-event');
    })->name('user.events.create');

    Route::get('/user/events/{event}/edit', function() {
        return view('user.edit-event');
    })->name('user.events.edit');

    // Route::get('/user/events/create', CreateEvent::class)->name('user.events.create');
});

// Route::get('/dashboard/events/create', function() {
//     return view('create-event');
// })->name('dashboard.events.create');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/dashboard', Dashboard::class)->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Route::get('settings/profile', Profile::class)->name('settings.profile');
//     Route::get('settings/password', Password::class)->name('settings.password');
//     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
// });

require __DIR__.'/auth.php';
