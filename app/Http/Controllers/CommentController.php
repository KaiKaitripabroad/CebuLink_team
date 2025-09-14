<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    // 投稿に紐づくコメント一覧をJSONで返す
    public function index(Post $post)
    {
        // コメントと一緒に、コメントしたユーザーの情報も取得する (N+1問題対策)
        $comments = $post->comments()->with('user')->get();

        return response()->json($comments);
    }
    public function store(Request $request,Post $post)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content'    => $request->content, // ここも content に変更
        ]);

        $comment->load('user');

        return response()->json($comment);
    }
}
