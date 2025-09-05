@extends('layouts.home_style')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection

@section('content')

<main>
    <div class="image-area">
        <img src="event-photo.jpg" alt="イベント画像">
    </div>
    <div class="form-group">
        <label for="title">title:</label>
        <input type="text" id="title" value="語学交流会">
    </div>

    <div class="form-group">
        <label for="text">text:</label>
        <textarea id="text" rows="3">他校の留学生と仲を広げるコミュニティーです</textarea>
    </div>

    <div class="form-group">
        <label for="date">date:</label>
        <input type="text" id="date" value="9/28">
    </div>

    <div class="form-group">
        <label for="time">time:</label>
        <input type="text" id="time" value="12:00～">
    </div>

    <div class="form-group">
        <label for="location">location:</label>
        <input type="text" id="location" value="ビジネスパーク">
    </div>

    <div class="tag-section">
        <label>tag:</label>
        <div class="tags">
            <button class="tag yellow">food</button>
            <button class="tag orange">shop</button>
            <button class="tag purple">event</button>
            <button class="tag green">volunteer</button>
            <button class="tag pink">sightseeing</button>
            <button class="tag blue">others</button>
        </div>
    </div>

    <button class="share-button">share</button>
</main>
@endsection
