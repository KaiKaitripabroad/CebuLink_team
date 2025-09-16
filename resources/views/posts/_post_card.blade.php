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
        {{-- ★ ログインしているユーザーにだけ表示されるアクション --}}
        @auth
            <div class="actions-left" style="display: flex; align-items: center; gap: 50px;">
                {{-- いいね --}}
                <div class="like-section" id="like-section-{{ $post->id }}">
                    @if ($post->isLikedBy(Auth::user()))
                        <form action="{{ route('posts.unlike', $post) }}" method="POST" class="like-form" data-post-id="{{ $post->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="like-button"><i class="fas fa-heart" style="color: #f21818;"></i></button>
                        </form>
                    @else
                        <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form" data-post-id="{{ $post->id }}">
                            @csrf
                            <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                        </form>
                    @endif
                </div>
                {{-- コメント --}}
                <button type="button" class="comment-toggle-button" data-post-id="{{ $post->id }}">
                    <i class="far fa-comment" style="font-size: 24px; color: #333;"></i>
                </button>
            </div>
            {{-- ブックマーク --}}
            <div class="bookmark-section" id="bookmark-section-{{ $post->id }}">
                @if ($post->isBookmarkedBy(Auth::user()))
                    <form action="{{ route('posts.unbookmark', $post) }}" method="POST" class="bookmark-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bookmark-button"><i class="fas fa-bookmark" style="font-size: 28px; color: #ffc107;"></i></button>
                    </form>
                @else
                    <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="bookmark-form">
                        @csrf
                        <button type="submit" class="bookmark-button"><i class="far fa-bookmark" style="font-size: 28px; color: #333;"></i></button>
                    </form>
                @endif
            </div>
        @endauth

        {{-- ★ ゲスト（未ログイン）ユーザーにだけ表示されるアクション --}}
        @guest
            <div class="actions-left" style="display: flex; align-items: center; gap: 50px;">
                {{-- ログインページへ誘導するアイコン --}}
                <a href="{{ route('login') }}"><i class="far fa-heart" style="opacity: 0.5;"></i></a>
                <a href="{{ route('login') }}"><i class="far fa-comment" style="font-size: 24px; color: #333; opacity: 0.5;"></i></a>
            </div>
            <a href="{{ route('login') }}"><i class="far fa-bookmark" style="font-size: 28px; color: #333; opacity: 0.5;"></i></a>
        @endguest
    </div>

    {{-- コメント欄 (ログインユーザーのみ) --}}
    @auth
        <div class="comments-container" id="comments-container-{{ $post->id }}" style="display: none; margin-top: 10px;">
            {{-- ... コメントの表示と投稿フォーム ... --}}
        </div>
    @endauth

    <div class="post-content">
        <span class="tag">tag_placeholder</span>
        <p class="caption">{{ $post->text }}</p>
    </div>
</article>
