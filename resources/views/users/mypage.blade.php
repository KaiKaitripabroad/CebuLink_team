@extends('layouts.common_header')

@section('content')
    <div id="menu" class="menu">
        <ul>
            <li><a href="{{ route('home') }}">設定</a></li>
            <li><a href="{{ route('home') }}">保存済み一覧</a></li>
            <li><a href="{{ route('home') }}">投稿編集</a></li>
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
                        <p class="username editable-text" data-target="username-input">{{ $user->username ?? $user->name }}</p>
                        {{-- 編集・送信用で非表示のinputタグ --}}
                        <input type="text" name="username" value="{{ $user->username ?? $user->name }}" id="username-input"
                            style="display: none;">

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
        <div class="posts-row">
            {{-- 投稿画像をループで表示する例（実際にはデータベースから取得） --}}
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500" alt="Post Image 1">
            </div>
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=500" alt="Post Image 2">
            </div>
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500" alt="Post Image 3">
            </div>
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500" alt="Post Image 4">
            </div>
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500" alt="Post Image 5">
            </div>
            <div class="post-item">
                <img src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=500" alt="Post Image 6">
            </div>
        </div>
    </div>
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
