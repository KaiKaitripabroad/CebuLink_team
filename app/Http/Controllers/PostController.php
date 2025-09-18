<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
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
    public function post_event()
    {
        return view('posts.post_event');
    }

    public function edit(Post $post)
    {
        // 自分の投稿以外をブロックしたいなら:
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, Post $post)
    {


        // 投稿が自分のものでない場合は403エラー
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        // バリデーション
        $request->validate([
            'img_url' => 'nullable|image|max:5120', // 5MBまで
            'text'    => 'nullable|string|max:1000',
        ]);

        // 画像もテキストも空ならエラー
        if (!$request->hasFile('img_url') && empty($request->text)) {
            return back()->withErrors(['input' => '画像またはテキストを入力してください'])->withInput();
        }

        if ($request->hasFile('img_url')) {
            // 古い画像を削除
            if ($post->img_url) {
                Storage::disk('public')->delete($post->img_url);
            }
            $post->img_url = $request->file('img_url')->store('uploads', 'public');
        }

        $post->text = $request->text;
        $post->save();

        return redirect()->route('users.mypage')->with('success', '投稿が更新されました');
    }
    public function destroy(Post $post)
    {
        // 投稿が自分のものでない場合は403エラー
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        // 画像がある場合は削除
        if ($post->img_url) {
            Storage::disk('public')->delete($post->img_url);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿が削除されました');
    }


    public function manage()
    {
        $posts = auth()->user()->posts()->latest()->get();
        return view('users.manage', compact('posts'));
    }
}
