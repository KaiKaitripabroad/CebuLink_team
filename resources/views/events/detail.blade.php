@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/event_detail.css') }}">
    <section class="event-detail">
        <div class="event-card">
            {{-- イベント画像 --}}
            <img src="{{ $event->img_url ? asset('storage/' . $event->img_url) : asset('images/no-image.png') }}"
                class="event-image">

            {{-- イベント情報 --}}
            <div class="event-info">
                <p class="event-date">{{ \Carbon\Carbon::parse($event->date)->format('n/j') }} <br>
                    {{ \Carbon\Carbon::parse($event->start_at)->format('H:i') }}~
                    {{ \Carbon\Carbon::parse($event->end_at)->format('H:i') }}
                </p>
                <h2 class="event-title">{{ $event->title }}</h2>
                <p class="event-text">{{ $event->text }}</p>

                {{-- 場所 --}}
                <div class="event-location">
                    <span class="location-icon">イベント会場📍</span>
                </div>
                <div id="map" style="width:100%; height:300px;"></div>

                {{-- 参加ボタン --}}
                <div class="event-action">
                    <button class="join-btn">参加</button>
                </div>
            </div>
        </div>
        <script>
            let map;

            function initMap() {
                // PHPから座標を受け取る
                const lat = {{ $event->latitude ?? 'null' }};
                const lng = {{ $event->longitude ?? 'null' }};

                if (lat && lng) {
                    const position = {
                        lat: lat,
                        lng: lng
                    };

                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: position,
                    });

                    new google.maps.Marker({
                        position: position,
                        map: map,
                    });
                } else {
                    // 座標がない場合は東京駅を表示
                    const defaultCenter = {
                        lat: 35.681236,
                        lng: 139.767125
                    };
                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 14,
                        center: defaultCenter,
                    });
                }

            }
        </script>


        <!-- ★ここにAPIキーを入れる -->
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwQGr3lEXxIF39xTbSl4exUYGIXMiErj0&callback=initMap"></script>
    </section>
@endsection
