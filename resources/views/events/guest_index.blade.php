@extends('layouts.guest_style')

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
            @for ($i = 0; $i <= 10; $i++)
                <a href="{{ route('events.detail_guest') }}"class="event-card">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500" class="event-image">
                    <div class="event-info">
                        <h3>aaa</h3>
                        <p>aa</p>
                    </div>
                </a>
            @endfor
        </div>
    </section>
    <script src="{{ asset('js/event_style.js') }}"></script>
@endsection
