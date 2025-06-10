<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('events');
    }

    public function show(Event $event)
    {
        // TO DO: this should return the detail view for a single event
        return view('events');
    }
}
