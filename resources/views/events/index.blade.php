@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/event_style.css') }}">
    {{-- カレンダ部分 --}}
    <div class="calendar-container">
        <button id="prev" class="nav-btn">＜</button>
        <div id="date-list" class="date-list"></div>
        <button id="next" class="nav-btn">＞</button>
    </div>
    {{-- イベント情報 --}}
    <section class="event-section">
        <div class="infrom">
            <h1 id="selected-date">ALL</h1>
            <h1>Cebu イベント情報</h1>
        </div>
        <div class="event-list">
            @foreach ($events as $event)
                <a href="{{ route('events.detail', $event->id) }}" class="event-card">
                    <img src="{{ $event->img_url ? asset('storage/' . $event->img_url) : asset('images/no-image.png') }}"
                        alt="イベント画像" class="event-image">
                    <div class="event-info">
                        <h3>{{ $event->title }}</h3>
                        <p>{{ Str::limit($event->text, 50) }}</p>
                    </div>
                </a>
            @endforeach

        </div>
    </section>
    <script src="{{ asset('js/event_style.js') }}"></script>
@endsection
