@extends('layouts.common_header')

@section('content')
    <div id="menu" class="menu">
        <ul>
            <li><a href="{{ route('home') }}">設定</a></li>
            <li><a href="{{ route('users.manage') }}">投稿編集</a></li>
            <li><a href="{{ route('bookmark.index') }}">保存済み一覧</a></li>
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
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <div class="profile-container">
        <div class="wakusen">
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                {{-- プロフィールヘッダー --}}
                <div class="profile-header" style="display: flex; space-between; align-items: center;">
                    <div class="profile-icon">
                        {{-- 実際にはユーザーのアイコン画像へのパスを指定します --}}
                        @if (isset($profile) && $profile->profile_image_url)
                            <img id="profileImage" src="{{ $profile->profile_image_url }}" alt="Profile Icon">
                        @else
                            <img id="profileImage" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500"
                                alt="Profile Icon">
                        @endif
                        <input type="file" id="profileInput" name="profile_image" accept="image/*" style="display:none;">
                    </div>
                    <div class="profile-info">
                        {{-- 表示用のpタグ --}}
                        <p class="username editable-text" data-target="username-input">{{ $user->username ?? $user->name }}
                        </p>
                        {{-- 編集・送信用で非表示のinputタグ --}}
                        <input type="text" name="username" value="{{ $user->username ?? $user->name }}"
                            id="username-input" style="display: none;">

                        {{-- 表示用のpタグ --}}
                        <p class="name editable-text" data-target="name-input">{{ $user->name }}</p>
                        {{-- 編集・送信用で非表示のinputタグ --}}
                        <input type="text" name="name" value="{{ $user->name }}" id="name-input"
                            style="display: none;">
                    </div>
                </div>

                <div class="profile-bio">
                    {{-- 表示用のpタグ --}}
                    <p class="editable-text" data-target="bio-textarea">
                        @if ($profile && $profile->bio)
                            {!! nl2br(e($profile->bio)) !!}
                        @else
                            自己紹介を記載しよう！！
                        @endif
                    </p>
                    {{-- 編集・送信用で非表示のtextarea --}}
                    <textarea name="bio" id="bio-textarea" class="bio-textarea" style="display: none;">{{ optional($profile)->bio }}</textarea>
                </div>
                <button type="submit">保存する</button>
            </form>
        </div>

        {{-- 投稿グリッド --}}
        {{-- 投稿グリッド（自分の投稿一覧） --}}
        @php
            use Illuminate\Support\Facades\Storage;
        @endphp

        @if (session('success'))
            <div class="flash success">{{ session('success') }}</div>
        @endif

        <div class="posts-row">
            @forelse ($posts as $post)
                <div class="post-item">
                    {{-- @if ($post->img_url)
                            <img src="{{ Storage::url($post->img_url) }}" alt="{{ $post->title }}">
                        @else
                            <img src="{{ asset('images/noimage.png') }}" alt="No image">
                        @endif --}}
                    <div class="post-thumb landscape">
                        @if ($post->img_url)
                            <img src="{{ Storage::url($post->img_url) }}" alt="{{ $post->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('images/noimage.png') }}" alt="No image" loading="lazy">
                        @endif
                    </div>

                </div>
            @empty
                <p>まだ投稿がありません。<a href="{{ route('posts.create') }}">最初の投稿を作成</a></p>
            @endforelse
        </div>

        <script src="{{ asset('js/profile.js') }}"></script>
    @endsection
