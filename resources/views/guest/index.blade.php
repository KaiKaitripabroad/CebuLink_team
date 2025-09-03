@extends('layouts.home_style')

@section('content')
    <div class="search-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </div>

    <div class="filter-container">
        <button class="filter-btn food">food</button>
        <button class="filter-btn shop">shop</button>
        <button class="filter-btn event">event</button>
        <div class="dropdown-arrow"></div>
    </div>

    <article class="post-card">
        <div class="post-header">
            <p class="post-author">@fukushi</p>
        </div>
        <div class="post-image-container">
            <img src="https://images.unsplash.com/photo-1548291683-058b2e2a6d5f?q=80&w=1887&auto=format&fit=crop"
                alt="10000 roses">
        </div>
        <div class="post-actions">
            <div class="actions-left">
                <svg class="icon-heart" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                    fill="red" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="actions-right">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="post-content">
            <span class="tag">sightseeing</span>
            <p class="caption">
                10000 rosesに行ってきた！<br>
                夕焼け＆バラが綺麗なので是非！
            </p>
        </div>
    </article>
@endsection
