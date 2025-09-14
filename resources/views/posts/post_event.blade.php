@extends('layouts.home_style')

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection
<main>
    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="start_time">イベント開始時刻:</label>
            <input type="time" id="start_time" name="start_time">

            <label for="end_time">イベント終了時刻:</label>
            <input type="time" id="end_time" name="end_time">
        </div>

        {{-- 場所 --}}
        <label>開催場所を検索してください</label>

        <!-- 入力欄とボタン -->
        <input type="text" id="address" class="search-box" placeholder="例: 東京駅">
        <button type="button" class="search-btn" onclick="codeAddress()">検索</button>
        <div id="map"></div>
        <p>検索結果: <span id="result"></span></p>

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
    <a href="{{route('posts.index')}}" class="back-button">戻る</a>

    <script>
        let map, geocoder, marker;

        function initMap() {
            // 初期表示（東京駅）
            const center = {
                lat: 35.681236,
                lng: 139.767125
            };
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: center,
            });
            geocoder = new google.maps.Geocoder();
            marker = new google.maps.Marker({
                map: map
            });
        }

        // 住所から地図表示
        function codeAddress() {
            const inputAddress = document.getElementById("address").value;

            geocoder.geocode({
                address: inputAddress
            }, (results, status) => {
                if (status === "OK") {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);

                    // 結果を表示
                    document.getElementById("result").textContent =
                        results[0].formatted_address;
                } else {
                    alert("ジオコーディング失敗: " + status);
                }
            });
        }
    </script>

    <!-- ★ここにAPIキーを入れる -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwQGr3lEXxIF39xTbSl4exUYGIXMiErj0&callback=initMap"></script>
    <script src="{{ asset('js/post.js') }}"></script>
</main>
@endsection
