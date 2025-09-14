<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- ← これ追加 -->
    <title>CebuLink+</title>
    <link rel="stylesheet" href="{{ asset('css/home_style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=M+PLUS+Rounded+1c:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('styles')
    @yield('css')
</head>

<body>
    <div class="mobile-container">
        <header class="header">
            <h1 class="logo">CebuLink+</h1>
        </header>

        <main class="main-content">
            @yield('content')
        </main>

        @include('layouts.footer')

    </div>
    @yield('scripts')
</body>

</html>
