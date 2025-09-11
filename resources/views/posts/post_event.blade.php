@extends('layouts.home_style')

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection
<main>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="upload-wrapper">
            <label for="imageUpload" class="upload-box">
                <span class="plus-icon" @if (!empty($post?->img_url)) style="display:none;" @endif>＋</span>
                <img id="preview" src="{{ !empty($post?->img_url) ? asset('storage/' . $post->img_url) : '' }}"
                    alt="Image Preview" class="preview-image"
                    style="{{ !empty($post?->img_url) ? '' : 'display:none;' }}">
            </label>
            <input type="file" name="img_url" id="imageUpload" accept="image/*" hidden>

            {{-- DBに保存されている画像があれば表示 --}}
            @if ($errors->any())
                <script>
                    alert("{{ implode('\n', $errors->all()) }}");
                </script>
            @endif
        </div>

        {{-- イベントタイトル --}}
        <div class="form-group">
            <label for="title">title:</label>
            <input type="text" id="title" name="title" placeholder="イベント名を入力">
        </div>

        {{-- イベント本文 --}}
        <div class="form-group">
            <label for="text">text:</label>
            <textarea id="text" rows="4" placeholder="イベントの詳細を入力" name="text"></textarea>
        </div>

        {{-- 日付 --}}
        <div class="form-group">
            <label for="date">date:</label>
            <input type="date" id="date" name="date" placeholder="例: 9/28">
        </div>

        {{-- 時間 --}}
        <div class="form-group">
            <label for="time">time:</label>
            <input type="text" id="time" name="time" placeholder="例: 12:00〜">
        </div>

        {{-- 場所 --}}
        <div class="form-group">
            <input type="text" id="location" name="location" placeholder="場所を入力">
            <button type="button" onclick="openMap()">地図から選ぶ</button>
        </div>

        {{-- タグ --}}
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
    </form>
    <button class="back-button" onclick="history.back()">戻る</button>
    <script src="{{ asset('js/post.js') }}"></script>
</main>
@endsection
