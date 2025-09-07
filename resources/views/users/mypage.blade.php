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
            
            {{-- プロフィールヘッダー --}}
            <div class="profile-header" style="display: flex; jastify-content:space-between; align-items: center;">
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
                    <p class="username">@@{{ $user - > name }}</p>
                    <p class="name">{{ $user->name }}</p>
                </div>
            </div>

            {{-- 自己紹介 --}}
            <div class="profile-bio">
                @if ($profile)
                    <p>{!! nl2br(e($profile->bio)) !!}</p>
                    <textarea id="bio-textarea" class="bio-textarea" style="display: none;">{{ $profile->bio }}</textarea>
                @else
                    <p>自己紹介を記載しよう！！</p>
                    <textarea id="bio-textarea" class="bio-textarea" style="display: none;"></textarea>
                @endif
            </div>
            <button type="submit">保存する</button>
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
