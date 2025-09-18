@extends('layouts.app') {{-- ← レイアウトファイルを継承 --}}

@section('content')
    <div class="post-card">
        <div class="post-body">
            <p>{{ $post->text }}</p>
            @if ($post->img_url)
                <img src="{{ asset('storage/' . $post->img_url) }}" alt="投稿画像">
            @endif
        </div>

        {{-- 🔴 タグ表示部分 --}}
        @if ($post->tags->isNotEmpty())
            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
@endsection
