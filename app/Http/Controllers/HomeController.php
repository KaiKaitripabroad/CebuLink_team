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
        $posts = Post::with(['user', 'comments', 'tags'])->latest()->get();

        return view('home', compact('posts', 'user'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where(function ($query) use ($keyword) {
            $query->where('text', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('username', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%");
                });
        })
            ->latest() // 最新の投稿から順に
            ->get();

        return view('home', compact('posts', 'keyword'));
    }
}
