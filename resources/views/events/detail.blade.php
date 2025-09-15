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
                <h2 class="event-title">格闘技観戦好きの会</h2>

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
