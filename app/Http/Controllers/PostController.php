<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // 新しい投稿から順に取得
        $posts = Post::with('user','tags')->withCount('likes')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        // フォームに表示するため全タグを取得
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('tags'));
    }
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'img_url' => 'nullable|image|max:5120',
            'text'    => 'nullable|string|max:1000',
            'tag'     => 'required|string|in:food,shop,event,volunteer,sightseeing,others',
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
        $post->user_id = Auth::id();
        $post->save();

        if ($request->has('tag')) {
            $tag = Tag::where('name', $request->tag)->first();
            if ($tag) {
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('home')->with('success', '投稿が作成されました');
    }
    public function edit($id)
    {
        return view('posts.edit', ['id' => $id]);
    }
    public function show($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }
    public function post_event()
    {
        return view('posts.post_event');
    }
}
