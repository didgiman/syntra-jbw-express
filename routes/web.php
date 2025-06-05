<?php

use App\Livewire\CreateEvent;
use App\Livewire\Dashboard;
use App\Livewire\EditEvent;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // grab the earliest upcoming events from the DB
    $upcomingEvents = Event::with(['attendees', 'type'])  // Added 'type' here
        ->where('start_time', '>=', now())
        ->orderBy('start_time')
        ->take(6)
        ->get();
    return view('welcome', compact('upcomingEvents'));
})->name('home');

Route::get('/events', function() {
    return view('events');
})->name('events');

Route::middleware(['auth'])->group(function () {

    Route::redirect('/user', '/user/events/hosting')->name('user');

    Route::get('/user/events/attending', function() {
        $events = Event::whereHas('attendees', function($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('start_time', 'DESC')->get();
        return view('user.attending', ['events' => $events]);
    })->name('user.events.attending');

    Route::get('/user/events/attending/past', function() {
        $events = Event::past()->whereHas('attendees', function($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('start_time', 'DESC')->get();
        return view('user.attending', ['events' => $events]);
    })->name('user.events.attending.past');

    Route::get('/user/events/hosting', function() {
        $events = Event::where('user_id', Auth::user()->id)->orderby('start_time', 'DESC')->with('type')->get();
        return view('user.hosting', ['events' => $events]);
    })->name('user.events.hosting');

    Route::get('/user/events/hosting/past', function() {
        $events = Event::past()->where('user_id', Auth::user()->id)->orderby('start_time', 'DESC')->with('type')->get();
        return view('user.hosting', ['events' => $events]);
    })->name('user.events.hosting.past');

    Route::get('/user/events/hosting/create', function() {
        return view('user.create-event');
    })->name('user.events.hosting.create');

    Route::get('/user/events/hosting/{event}/edit', function(Event $event) {
        // Only allow a user to manage their own events
        if ($event->user_id !== Auth::id()) {
            abort(404);
        }
        return view('user.edit-event', compact('event'));
    })->name('user.events.hosting.edit');

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
