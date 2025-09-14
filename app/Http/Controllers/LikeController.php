<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ← これを追加してください


class LikeController extends Controller
{
    public function like(Post $post, Request $request)
    {
        // attachメソッドは、すでに関連が存在する場合は重複して追加しない
        $post->likes()->syncWithoutDetaching([Auth::id()]);

        // 正しいいいね数を取得して返す
        $likesCount = $post->likes()->count();

        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }

    /**
     * 投稿の「いいね」を解除する
     */
    public function unlike(Post $post, Request $request)
    {
        $post->likes()->detach(Auth::id());

        // 正しいいいね数を取得して返す
        $likesCount = $post->likes()->count();

        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }
}
