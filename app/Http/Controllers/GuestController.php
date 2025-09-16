<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class GuestController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('guest.index', compact('posts'));

    }
}
