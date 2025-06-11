<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function allEvents(){
        return view('events');
    }

    public function carrouselEvents(){
        return view('events');
    }
}
