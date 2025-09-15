@extends('layouts.home_style')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <div class="search-container">
        <form action="{{ route('home.search') }}" method="GET">
            <input type="text" name="keyword" placeholder="検索..." value="{{ $keyword ?? '' }}" class="search-input">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </form>
    </div>

    <div class="filter-container">
        <button class="filter-btn food">food</button>
        <button class="filter-btn shop">shop</button>
        <button class="filter-btn event">event</button>
        <div class="dropdown-arrow"></div>
    </div>
    @foreach ($posts as $post)
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
            <div class="post-actions">
                <div class="actions-left" style="display: flex; align-items: center; gap: 50px;">
                    <div class="like-section" id="like-section-{{ $post->id }}">
                        @if ($post->isLikedBy(Auth::user()))
                            <form action="{{ route('posts.unlike', $post) }}" method="POST" class="like-form"
                                data-post-id="{{ $post->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="like-button">
                                    <i class="fas fa-heart" style="color: #f21818;"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form"
                                data-post-id="{{ $post->id }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="like-button">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- いいね機能のすぐ隣に配置 --}}
                    <button type="button" class="comment-toggle-button" data-post-id="{{ $post->id }}">
                        <i class="far fa-comment" style="font-size: 24px; color: #333;"></i>
                    </button>
                </div>
                <div class="bookmark-section" id="bookmark-section-{{ $post->id }}">
                    @if ($post->isBookmarkedBy(Auth::user()))
                        {{-- ★ ブックマーク済みの場合（解除フォーム） --}}
                        <form action="{{ route('posts.unbookmark', $post) }}" method="POST" class="bookmark-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bookmark-button">
                                {{-- 塗りつぶされたアイコン --}}
                                <i class="fas fa-bookmark" style="font-size: 28px; color: #ffc107;"></i>
                            </button>
                        </form>
                    @else
                        {{-- ★ 未ブックマークの場合（登録フォーム） --}}
                        <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="bookmark-form">
                            @csrf
                            <button type="submit" class="bookmark-button">
                                {{-- 枠線のアイコン --}}
                                <i class="far fa-bookmark" style="font-size: 28px; color: #333;"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="comments-container" id="comments-container-{{ $post->id }}"
                style="display: none; margin-top: 10px;">

                <div class="comments-list">
                    @foreach ($post->comments as $comment)
                        <div
                            class="comment-item
                @if ($comment->user_id === Auth::id()) my-comment @else other-comment @endif">
                            <strong>{{ $comment->user->name }}</strong>
                            <span>{{ $comment->content }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- コメント投稿フォーム --}}
                <form action="{{ route('comments.store', $post) }}" method="POST" class="new-comment-form"
                    data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="text" name="content" class="comment-input" placeholder="コメントを追加..." required>
                    <button type="submit" class="comment-submit-button">投稿</button>
                </form>
            </div>
            <div class="post-content">
                <span class="tag">tag_placeholder</span>
                <p class="caption">{{ $post->text }}</p>
            </div>
        </article>
    @endforeach
@endsection
@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
