<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    //
    public function store(Post $post)
    {
        /** @var \App\Models\User $user */ //
        Auth::user()->bookmarkedPosts()->attach($post->id);
        return response()->json(['success' => true]);
    }

    // ブックマークを削除する処理
    public function destroy(Post $post)
    {
        /** @var \App\Models\User $user */ //
        Auth::user()->bookmarkedPosts()->detach($post->id);
        return response()->json(['success' => true]);
    }
    public function index()
    {
        /** @var \App\Models\User $user */ //
        $bookmarkedPosts = Auth::user()->bookmarkedPosts()->with('user')->withCount('likes')->latest()->get();
        return view('bookmark.index', compact('bookmarkedPosts'));
    }
}
