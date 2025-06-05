<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    use AuthorizesRequests;

    public function hosting()
    {
        $events = Event::where('user_id', Auth::id())
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        return view('user.hosting', ['events' => $events]);
    }

    public function hostingPast()
    {
        $events = Event::where('user_id', Auth::id())
            ->past()
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        return view('user.hosting', ['events' => $events]);
    }

    public function attending()
    {
        $events = Event::whereHas('attendees', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->orderBy('start_time', 'DESC')->get();
        
        return view('user.attending', ['events' => $events]);
    }

    public function attendingPast()
    {
        $events = Event::past()
            ->whereHas('attendees', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('start_time', 'DESC')
            ->get();
        
        return view('user.attending', ['events' => $events]);
    }

    public function edit(Event $event)
    {
        // Authorize user
        $this->authorize('update', $event);

        return view('user.edit-event', compact('event'));
    }

    public function summary()
    {
        $userId = Auth::id();

        $hosting = Event::createdBy($userId)
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        $hostingPast = Event::createdBy($userId)
            ->past()
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        $attending = Event::attendedBy($userId)
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        $attendingPast = Event::attendedBy($userId)
            ->past()
            ->with('type')
            ->orderByDesc('start_time')
            ->get();

        return view('user.summary', compact('hosting', 'hostingPast', 'attending', 'attendingPast'));
    }
}
