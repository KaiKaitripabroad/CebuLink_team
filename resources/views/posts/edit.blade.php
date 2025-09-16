@extends('layouts.common_header')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}"> {{-- ← これ必須！ --}}
    <div class="profile-container" style="max-width:720px;margin:0 auto;padding:20px;">
        <h2 style="margin-bottom:16px;">投稿を編集</h2>
        {{-- フラッシュメッセージ --}}
        @if (session('status'))
            <div class="alert alert-success" style="margin-bottom:12px;">{{ session('status') }}</div>
        @endif
        {{-- 投稿画像のプレビュー --}}
        <div class="post-thumb landscape">
            @if ($post->img_url)
                <img src="{{ Storage::url($post->img_url) }}" alt="post image" loading="lazy">
            @else
                <img src="{{ asset('images/noimage.png') }}" alt="no image" loading="lazy">
            @endif
        </div>

        {{-- 編集フォーム --}}
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label for="text"></label>
            <textarea name="text" id="text" rows="3" style="width:100%;margin-bottom:8px;">{{ old('text', $post->text) }}</textarea>
            @error('text')
                <div class="error" style="color:#d33;margin-bottom:8px;">{{ $message }}</div>
            @enderror

            <div style="margin-top:16px; display:flex; gap:8px;">
                <button type="submit" class="btn">更新する</button>
                <a href="{{ route('users.manage') }}" class="btn btn-secondary">戻る</a>
            </div>
        </form>
    </div>
@endsection
