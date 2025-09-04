@extends('layouts.home_style')

@section('content')
    <main>
        <a href="{{ route('posts.create') }}" class="post-button normal">通常投稿</a>
        <a href="{{ route('posts.create') }}" class="post-button event">イベント投稿</a>
    </main>
@endsection
