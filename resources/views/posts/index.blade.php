@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <main>
        <a href="{{ route('posts.create') }}" class="post-button post-button_normal">通常投稿</a>
        <a href="{{ route('posts.post_event') }}" class="post-button post-button_event">イベント投稿</a>
    </main>
@endsection
