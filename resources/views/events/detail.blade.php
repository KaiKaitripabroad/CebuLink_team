@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/event_detail.css') }}">
    <section class="event-detail">
        <div class="event-card">
            {{-- イベント画像 --}}
            <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=600" alt="イベント画像" class="event-image">

            {{-- イベント情報 --}}
            <div class="event-info">
                <p class="event-date">9/15 15:00~</p>
                <h2 class="event-title">格闘技観戦好きの会</h2>

                <p class="event-description">
                    格闘技が好きな方大集合<br>
                    好きな格闘家について talk!<br>
                    best game 観戦して趣味を共有しよう！
                </p>

                {{-- 場所 --}}
                <div class="event-location">
                    <span class="location-icon">📍</span>
                    <div>
                        <p>The Pad Co-Living</p>
                        <a href="https://maps.app.goo.gl/6tGoFAzGYRvZZuPR7" target="_blank">
                            https://maps.app.goo.gl/6tGoFAzGYRvZZuPR7
                        </a>
                    </div>
                </div>

                {{-- 参加ボタン --}}
                <div class="event-action">
                    <button class="join-btn">参加</button>
                </div>
            </div>
        </div>
    </section>
@endsection
