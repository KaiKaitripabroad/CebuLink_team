@extends('layouts.guest_style')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    {{-- ... 検索フォームやフィルターボタン ... --}}

    @foreach ($posts as $post)
        {{-- ★ こちらも同じ部品を呼び出す！ --}}
        @include('posts._post_card', ['post' => $post])
    @endforeach
@endsection
