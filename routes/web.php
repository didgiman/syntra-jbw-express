<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// route to: all events
Route::get('/events', function () {
    return view('all_events');
})->name('all_events');

// grab the earliest upcoming events from the DB
use App\Models\Event;

Route::get('/', function () {
    $upcomingEvents = Event::where('start_time', '>=', now())
        ->orderBy('start_time')
        ->take(6)
        ->get();
    return view('welcome', compact('upcomingEvents'));
})->name('welcome');

require __DIR__.'/auth.php';
