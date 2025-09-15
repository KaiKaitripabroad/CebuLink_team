<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // 新しい投稿から順に取得
        $posts = Post::with('user')->withCount('likes')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }
    function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'img_url' => 'nullable|image|max:5120', // 5MBまで
            'text'    => 'nullable|string|max:1000',
        ]);

        // 画像もテキストも空ならエラー
        if (!$request->hasFile('img_url') && empty($request->text)) {
            return back()->withErrors(['input' => '画像またはテキストを入力してください'])->withInput();
        }

        $path = null;
        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('uploads', 'public');
        }

        $post = new Post();
        $post->img_url = $path;
        $post->text    = $request->text;
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.store')->with('success', '投稿が作成されました');
    }
    public function edit($id)
    {
        return view('posts.edit', ['id' => $id]);
    }
    public function show($id)
    {
        return view('posts.show', ['id' => $id]);
    }
    public function post_event()
    {
        return view('posts.post_event');
    }
}
