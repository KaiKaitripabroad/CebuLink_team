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

                <div class="event-info">
                    {{-- ... --}}

                    {{-- 現在の参加人数を表示 --}}
                    <p class="participant-info">
                        <span id="participant-count">{{ $event->participants->count() }}</span>人が参加予定
                    </p>

                    {{-- 参加ボタン --}}
                    <div class="event-action" id="participation-section">
                        @if ($event->isJoinedBy(Auth::user()))
                            {{-- 参加済みの場合 → キャンセルフォーム --}}
                            <form action="{{ route('events.cancel', $event) }}" method="POST" class="participation-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="join-btn cancel-btn">参加をキャンセルする</button>
                            </form>
                        @else
                            {{-- 未参加の場合 → 参加フォーム --}}
                            <form action="{{ route('events.join', $event) }}" method="POST" class="participation-form">
                                @csrf
                                <button type="submit" class="join-btn">参加する</button>
                            </form>
                        @endif
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
                document.addEventListener('submit', function(event) {
                    const form = event.target.closest('.participation-form');
                    if (!form) return;

                    event.preventDefault(); // 画面遷移を防ぐ

                    const url = form.action;
                    const method = form.querySelector('input[name="_method"]')?.value || 'POST';
                    const isJoining = (method === 'POST');

                    fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const section = document.getElementById('participation-section');
                                const countSpan = document.getElementById('participant-count');

                                // 参加人数を更新
                                countSpan.textContent = data.participant_count;

                                let newHtml = '';
                                if (isJoining) {
                                    // キャンセルボタンに書き換える
                                    const cancelUrl = url.replace('/join', '/cancel');
                                    newHtml = `
                    <form action="${cancelUrl}" method="POST" class="participation-form">
                        <input type="hidden" name="_token" value="${form.querySelector('input[name=_token]').value}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="join-btn cancel-btn">参加をキャンセルする</button>
                    </form>
                `;
                                } else {
                                    // 参加ボタンに書き換える
                                    const joinUrl = url.replace('/cancel', '/join');
                                    newHtml = `
                    <form action="${joinUrl}" method="POST" class="participation-form">
                        <input type="hidden" name="_token" value="${form.querySelector('input[name=_token]').value}">
                        <button type="submit" class="join-btn">参加する</button>
                    </form>
                `;
                                }
                                section.innerHTML = newHtml;
                            }
                        })
                        .catch(error => {
                            console.error('エラー:', error);
                            alert('処理中にエラーが発生しました。');
                        });
                });
            </script>

            <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwQGr3lEXxIF39xTbSl4exUYGIXMiErj0&callback=initMap"></script>
    </section>
@endsection
