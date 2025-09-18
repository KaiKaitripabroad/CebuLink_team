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
                {{-- いいねの状態に応じてフォームとアイコンを切り替え --}}
                @if (Auth::check() && $post->isLikedBy(Auth::user()))
                    {{-- いいね済みの場合（いいね解除フォーム） --}}
                    <form action="{{ route('posts.unlike', $post) }}" method="POST" class="like-form"
                        data-post-id="{{ $post->id }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        {{-- ★ buttonに 'icon-liked' クラスを追加 --}}
                        <button type="submit" class="like-button icon-liked">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                @else
                    {{-- まだいいねしていない場合（いいねフォーム） --}}
                    <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form"
                        data-post-id="{{ $post->id }}" style="display: inline;">
                        @csrf
                        {{-- ★ こちらのbuttonにはクラスは不要 --}}
                        <button type="submit" class="like-button">
                            <i class="far fa-heart"></i>
                        </button>
                    </form>
                @endif
            </div>

            <button type="button" class="comment-toggle-button" data-post-id="{{ $post->id }}">
                <i class="far fa-comment" style="font-size: 24px; color: #333;"></i>
            </button>
        </div>
        <span id="bookmark-section-{{ $post->id }}">
            {{-- ★ ブックマークの状態に応じてフォームとアイコンを切り替える --}}
            @if (Auth::check() && $post->isBookmarkedBy(Auth::user()))
                {{-- ブックマーク済みの場合（解除フォーム） --}}
                <form action="{{ route('posts.unbookmark', $post) }}" method="POST" class="bookmark-form"
                    data-post-id="{{ $post->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bookmark-button icon-bookmarked">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </form>
            @else
                {{-- まだブックマークしていない場合（登録フォーム） --}}
                <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="bookmark-form"
                    data-post-id="{{ $post->id }}">
                    @csrf
                    <button type="submit" class="bookmark-button">
                        <i class="far fa-bookmark"></i>
                    </button>
                </form>
            @endif
        </span>
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
        @if ($post->tags->isNotEmpty())
            <div class="post-tags">
                @foreach ($post->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                @endforeach
            </div>
        @else
            <div class="post-tags">
                <span class="tag">タグなし</span>
            </div>
        @endif

        <p class="caption">{{ $post->text }}</p>
    </div>
</article>
