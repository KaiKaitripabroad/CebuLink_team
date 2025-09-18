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
        {{-- ★ ログインユーザー用のアクション --}}
        @auth
            <div class="actions-left">
                {{-- いいね --}}
                <div class="like-section" id="like-section-{{ $post->id }}">
                    @if ($post->isLikedBy(Auth::user()))
                        <form action="{{ route('posts.unlike', $post) }}" method="POST" class="like-form"
                            data-post-id="{{ $post->id }}">
                            @csrf
                            @method('DELETE')
                            {{-- ★★★ style="..."を削除し、「icon-liked」クラスを追加 ★★★ --}}
                            <button type="submit" class="like-button"><i class="fas fa-heart icon-liked"></i></button>
                        </form>
                    @else
                        <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form"
                            data-post-id="{{ $post->id }}">
                            @csrf
                            {{-- ★★★ style="..."を削除 ★★★ --}}
                            <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                        </form>
                    @endif
                </div>
                {{-- コメント --}}
                {{-- ★★★ style="..."を削除 ★★★ --}}
                <button type="button" class="comment-toggle-button" data-post-id="{{ $post->id }}">
                    <i class="far fa-comment"></i>
                </button>
            </div>
            {{-- ブックマーク --}}
            <div class="bookmark-section" id="bookmark-section-{{ $post->id }}">
                @if ($post->isBookmarkedBy(Auth::user()))
                    <form action="{{ route('posts.unbookmark', $post) }}" method="POST" class="bookmark-form">
                        @csrf
                        @method('DELETE')
                        {{-- ★★★ style="..."を削除し、「icon-bookmarked」クラスを追加 ★★★ --}}
                        <button type="submit" class="bookmark-button"><i
                                class="fas fa-bookmark icon-bookmarked"></i></button>
                    </form>
                @else
                    <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="bookmark-form">
                        @csrf
                        {{-- ★★★ style="..."を削除 ★★★ --}}
                        <button type="submit" class="bookmark-button"><i class="far fa-bookmark"></i></button>
                    </form>
                @endif
            </div>
        @endauth

        {{-- ★ ゲスト（未ログイン）ユーザーにだけ表示されるアクション --}}
        @guest
            <div class="actions-left" style="display: flex; align-items: center; gap: 50px;">
                {{-- ログインページへ誘導するアイコン --}}
                <a href="{{ route('login') }}"><i class="far fa-heart" style="opacity: 0.5;"></i></a>
                <a href="{{ route('login') }}"><i class="far fa-comment"
                        style="font-size: 24px; color: #333; opacity: 0.5;"></i></a>
            </div>
            <a href="{{ route('login') }}"><i class="far fa-bookmark"
                    style="font-size: 28px; color: #333; opacity: 0.5;"></i></a>
        @endguest
    </div>

    {{-- コメント欄 (ログインユーザーのみ) --}}
    @auth
        <div class="comments-container" id="comments-container-{{ $post->id }}"
            style="display: none; margin-top: 10px;">
            <div class="comments-list">
                {{-- コメントはJavaScriptで非同期に読み込まれるため、ここは空でOK --}}
            </div>

            {{-- 新しいコメントを投稿するためのフォーム --}}
            <form action="{{ route('comments.store', $post) }}" method="POST" class="new-comment-form"
                data-post-id="{{ $post->id }}">
                @csrf
                <input type="text" name="content" class="comment-input" placeholder="コメントを追加..." required>
                <button type="submit" class="comment-submit-button">投稿</button>
            </form>
        </div>
    @endauth

    <div class="post-content">
        <span class="tag">tag_placeholder</span>
        <p class="caption">{{ $post->text }}</p>
    </div>
</article>
