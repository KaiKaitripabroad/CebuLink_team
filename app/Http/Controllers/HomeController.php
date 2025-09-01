<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');

        $posts = Post::query()
            ->when($category,fn($q)=>$q->where('category',$category))
            ->latest()
            ->get();

        $events = Event::latest()->take(5)->get();
        return view('home', compact('posts', 'events', 'category'));
    }
}
