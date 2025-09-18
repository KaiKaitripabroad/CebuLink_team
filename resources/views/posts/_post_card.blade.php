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
                            <i class="fas fa-heart"></i>
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
        <span id="bookmark-section-{{ $post->id }}">
            <form action="{{ route('posts.unbookmark', $post) }}" method="POST" class="bookmark-form"
                data-post-id="{{ $post->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bookmark-button">
                    <i class="fas fa-bookmark icon-bookmarked"></i> </button>
            </form>
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
