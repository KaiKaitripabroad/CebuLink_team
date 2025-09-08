<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function guest_index()
    {
        return view('events.guest_index');
    }
    public function index()
    {
        return view('events.index');
    }
}
