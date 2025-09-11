<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 投稿を新しい順に取得
        $user = Auth::user();
        $posts = Post::latest()->get();

        return view('home', compact('posts', 'user'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where('text', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('posts', 'keyword'));
    }
}
