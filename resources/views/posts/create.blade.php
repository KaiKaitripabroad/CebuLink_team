@extends('layouts.home_style')

{{-- CSSの読み込み --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection

{{-- コンテンツ --}}
@section('content')
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

                {{-- バリデーションエラーがあればアラート表示 --}}
                @if ($errors->any())
                    <script>
                        alert("{{ implode('\n', $errors->all()) }}");
                    </script>
                @endif
            </div>

            <div class="form-group">
                <label for="text">text:</label>
                <textarea id="text" rows="4" placeholder="本文を入力" name="text"></textarea>
            </div>

            <div class="tag-section">
                <label>tag:</label>
                <div class="tags">
                    <button type="button" class="tag yellow" data-value="food">food</button>
                    <button type="button" class="tag green" data-value="shop">shop</button>
                    <button type="button" class="tag blue" data-value="event">event</button>
                    <button type="button" class="tag orange" data-value="volunteer">volunteer</button>
                    <button type="button" class="tag pink" data-value="sightseeing">sightseeing</button>
                    <button type="button" class="tag purple" data-value="others">others</button>
                </div>
            </div>

            <!-- 実際に送信されるのはこの select -->
            <div class="form-group" style="display:none;">
                <label for="tag">タグを選択</label>
                <select name="tag" id="tag" class="form-control" required>
                    <option value="food">Food</option>
                    <option value="shop">Shop</option>
                    <option value="event">Event</option>
                    <option value="volunteer">Volunteer</option>
                    <option value="sightseeing">Sightseeing</option>
                    <option value="others">Others</option>
                </select>
            </div>



            <button type="submit" class="share-button">share</button>
        </form>

        <a href="{{ route('posts.index') }}" class="back-button">戻る</a>

        <script src="{{ asset('js/post.js') }}"></script>
    </main>
@endsection
