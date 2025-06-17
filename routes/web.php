<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserEventController;
use App\Livewire\CreateEvent;
use App\Livewire\Dashboard;
use App\Livewire\EditEvent;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Mail\AttendeeCreatedMail;
use App\Mail\ContactMessageCreatedMail;
use App\Mail\ContactMessageMail;
use App\Mail\ContactMessageReceivedMail;
use App\Mail\EventUpdatedMail;
use App\Models\Attendee;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    // Grab the earliest upcoming events from the DB
    $upcomingEvents = Event::with(['attendees', 'type'])
        ->orderBy('start_time')
        ->take(6)
        ->get();
    
    // Get statistics
    $stats = [
        'eventCount' => Event::count(),
        'userCount' => User::count(),
        'upcomingCount' => Event::where('start_time', '>', now())->count(),
        'registrationCount' => Attendee::count(),
        'freeEventCount' => Event::where('price', 0)->count(),
        'typeCount' => Type::count(),
    ];
    
    return view('welcome', compact('upcomingEvents', 'stats'));
})->name('home');

Route::get('/events', function() {
    return view('events');
})->name('events');

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/contact', function() {
    return view('contact');
})->name('contact');

Route::get('/events/{event}', function(Event $event) {
    return view('event-details', ['event' => $event]);
})->name('events.single');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/user', [UserEventController::class, 'summary'])
        ->name('user.summary');

    Route::get('/user/events/attending', [UserEventController::class, 'attending'])
        ->name('user.events.attending');

    Route::get('/user/events/attending/past', [UserEventController::class, 'attendingPast'])
        ->name('user.events.attending.past');

    Route::get('/user/events/hosting', [UserEventController::class, 'hosting'])
        ->name('user.events.hosting');

    Route::get('/user/events/hosting/past', [UserEventController::class, 'hostingPast'])
        ->name('user.events.hosting.past');

    Route::get('/user/events/hosting/create', function() {
        return view('user.create-event');
    })->name('user.events.hosting.create');

    Route::get('/user/events/hosting/{event}/edit', [UserEventController::class, 'edit'])
        ->name('user.events.hosting.edit');

    Route::get('/tickets/{attendee}/download', [TicketController::class, 'downloadTicket'])
        ->name('ticket.download');

    Route::get('/tickets/{event}/{user}/download', [TicketController::class, 'downloadTickets'])
        ->name('tickets.download');
});

Route::get('tickets/{token}/scan', [TicketController::class, 'scan'])
    ->name('ticket.scan');


// Route::get('/dashboard/events/create', function() {
//     return view('create-event');
// })->name('dashboard.events.create');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('user/settings', '/user/settings/profile')->name('user.settings');

    Route::get('user/settings/profile', Profile::class)->name('user.settings.profile');
    Route::get('user/settings/password', Password::class)->name('user.settings.password');
    Route::get('user/settings/appearance', Appearance::class)->name('user.settings.appearance');
});

Route::prefix('/testing')->group(function() {
    Route::prefix('/mails')->group(function() {
        Route::get('event-updated-email', function() {
            $event = Event::find(13);
            $attendee = Attendee::with('user')->find(21);

            return (new EventUpdatedMail($event, $attendee))->render();
        });

        Route::get('attendee-created-email', function() {
            $attendee = Attendee::with(['user', 'event'])->find(21);

            return (new AttendeeCreatedMail($attendee))->render();
        });

        Route::get('contact-created-email', function() {
            $contactMessage = ContactMessage::first();

            return (new ContactMessageCreatedMail($contactMessage))->render();
        });

        Route::get('contact-received-email', function() {
            $contactMessage = ContactMessage::first();

            return (new ContactMessageReceivedMail($contactMessage))->render();
        });
    });
});

require __DIR__.'/auth.php';
