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
            <h1 class="main-title">Cebu イベント情報</h1>
        </div>
        <div class="event-list">
            @include('events.partials.event-list', ['events' => $events])

        </div>
    </section>
    <script src="{{ asset('js/event_style.js') }}"></script>
@endsection
