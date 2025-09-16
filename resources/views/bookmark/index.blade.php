@extends('layouts.home_style')

@section('content')
    <div class="container">

        @if ($bookmarkedPosts->isEmpty())
            <p>ブックマークした投稿はまだありません。</p>
        @else
            {{-- 投稿データをループで表示 --}}
            @foreach ($bookmarkedPosts as $post)
                {{-- ここは既存の投稿表示カードのコードを貼り付けるのがオススメです --}}
                <article class="post-card">
                    <div class="post-header">
                        <p class="post-author">
                            {{ $post->user ? '@' . ($post->user->username ?? $post->user->name) : '@unknown' }}
                        </p>
                    </div>
                    <div class="post-image-container">
                        @if ($post->img_url)
                            <img src="{{ asset('storage/' . $post->img_url) }}" alt="Post Image">
                        @endif
                    </div>
                    {{-- いいねやコメント、ブックマークのボタン類もここに含める --}}
                    {{-- ... --}}
                    <div class="post-content">
                        <p class="caption">{{ $post->text }}</p>
                    </div>
                </article>
            @endforeach
        @endif
    </div>
@endsection
