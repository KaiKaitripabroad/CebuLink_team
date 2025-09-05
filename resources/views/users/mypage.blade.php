@extends('layouts.common_header')

@section('content')
{{-- <header class="header"> --}}
    {{-- <h1 class="logo">CebuLink+</h1> --}}
    {{-- <button class="menu-toggle" onclick="toggleMenu()">☰</button> --}}
{{-- </header> --}}
<div id="menu" class="menu">
    <ul>
        <li><a href="{{ route('home') }}">ホーム</a></li>
        <li><a href="{{ route('events.index') }}">イベント</a></li>
        <li><a href="{{ route('posts.index') }}">投稿一覧</a></li>
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
    {{-- プロフィールヘッダー --}}
    <div class="profile-header">
        <div class="profile-icon">
            {{-- 実際にはユーザーのアイコン画像へのパスを指定します --}}
            <img src="https://via.placeholder.com/150" alt="Profile Icon">
        </div>
        <div class="profile-info">
            <p class="username">@coco.121</p>
            <p class="name">こころ/cocoro</p>
        </div>
    </div>

    {{-- 自己紹介 --}}
    <div class="profile-bio">
        <p>1999 Japan Cebu</p>
        <p>プログラミング英語勉強中</p>
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
@endsection
