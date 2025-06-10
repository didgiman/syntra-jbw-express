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
        return view('user.hosting', ['view' => 'hosting']);
    }

    public function hostingPast()
    {
        return view('user.hosting', ['view' => 'hosting.past']);
    }

    public function attending()
    {
        return view('user.attending', ['view' => 'attending']);
    }

    public function attendingPast()
    {
        return view('user.attending', ['view' => 'attending.past']);
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
