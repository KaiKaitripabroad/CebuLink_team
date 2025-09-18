@extends('layouts.home_style')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <div class="search-container">
        <form action="{{ route('home.search') }}" method="GET">
            <input type="text" name="keyword" placeholder="検索..." value="{{ $keyword ?? '' }}" class="search-input">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </form>
    </div>

    <div class="filter-container">
        <button class="filter-btn food">food</button>
        <button class="filter-btn shop">shop</button>
        <button class="filter-btn event">event</button>
        <div class="dropdown-arrow"></div>
    </div>
    @foreach ($posts as $post)
        {{-- ★ こちらも同じ部品を呼び出す！ --}}
        @include('posts._post_card', ['post' => $post])
    @endforeach
@endsection
@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
