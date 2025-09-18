@extends('layouts.common_header')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <div id="menu" class="menu">
        <ul>
            <li><a href="{{ route('home') }}">設定</a></li>
            <li><a href="{{ route('home') }}">保存済み一覧</a></li>
            <li><a href="{{ route('users.manage') }}">投稿編集</a></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#333;font-size:18px;cursor:pointer;">
                        ログアウト
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <script>
        function toggleMenu() {
            document.getElementById('menu').classList.toggle('active');
        }
    </script>

    <div class="profile-container">
        <h2 style="margin:16px 0 8px;">投稿の編集・削除</h2>

        <div class="posts-row">
            @forelse ($posts as $post)
                <div class="post-item">
                    <div class="post-thumb landscape">
                        @if ($post->img_url)
                            <img src="{{ Storage::url($post->img_url) }}" alt="post image" loading="lazy">
                        @else
                            <img src="{{ asset('images/noimage.png') }}" alt="no image" loading="lazy">
                        @endif

                        {{-- 画像右上に操作ボタンをオーバーレイ（好み） --}}
                        <div class="post-actions--fab">
                            <a class="icon-btn" href="{{ route('posts.edit', $post) }}" title="編集">✎</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                onsubmit="return confirm('本当に削除しますか？')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn danger" title="削除">🗑</button>
                            </form>
                        </div>
                    </div>

                    <div class="post-actions">
                        <a class="btn" href="{{ route('posts.edit', $post) }}">編集</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('本当に削除しますか？')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>まだ投稿がありません。</p>
            @endforelse
        </div>
    </div>
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
