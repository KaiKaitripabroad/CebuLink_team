@extends('layouts.home_style')

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection
<main>
    <div class="upload-area">
        <div class="plus-icon">＋</div>
        <p>画像を追加</p>
    </div>

    <div class="form-group">
        <label for="title">title:</label>
        <input type="text" id="title" placeholder="タイトルを入力">
    </div>

    <div class="form-group">
        <label for="text">text:</label>
        <textarea id="text" rows="4" placeholder="本文を入力"></textarea>
    </div>

    <div class="tag-section">
        <label>tag:</label>
        <div class="tags">
            <button class="tag yellow">food</button>
            <button class="tag green">shop</button>
            <button class="tag blue">event</button>
            <button class="tag orange">volunteer</button>
            <button class="tag pink">sightseeing</button>
            <button class="tag purple">others</button>
        </div>
    </div>

    <button class="share-button">share</button>
    <button class="back-button" onclick="history.back()">戻る</button>
</main>
@endsection
