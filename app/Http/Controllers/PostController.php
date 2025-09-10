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
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }
    function store(Request $request)
    {
        // dd($request);
        // ファイルがあれば保存
        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('uploads', 'public');
        }
        //$requestに入っている値を、new Postでデータベースに保存するという記述
        $post = new Post;
        //左辺:テーブル、右辺が送られてきた値(fromから送られてきたnameが入っている)
        $post->img_url = $path ?? null;
        $post->text = $request->text;
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.store', $post);
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
