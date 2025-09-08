@extends('layouts.home_style')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/event_style.css') }}">
    {{-- カレンダ部分 --}}

    {{-- イベント情報 --}}
    <section class="event-section">
        <div class="infrom">
            <h1>Sep 1</h1>
            <h1>Cebu イベント情報</h1>
        </div>
        <div class="event-list">
            @for ($i = 0; $i <= 10; $i++)
                <div class="event-card">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500" class="event-image">
                    <div class="event-info">
                        <h3>aaa</h3>
                        <p>aa</p>
                    </div>
                </div>
            @endfor
        </div>
    </section>
@endsection
