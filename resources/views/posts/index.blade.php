@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <main>
        <span class="sign-post"></span> <!-- 共通の棒 -->
        <a href="{{ route('posts.create') }}" class="post-button post-button_normal">通常投稿</a>
        <span class="sign-post"></span>
        {{-- イベント投稿ページへのリンク --}}
        <a href="{{ route('posts.post_event') }}" class="post-button post-button_event">イベント投稿</a>
    </main>
@endsection
