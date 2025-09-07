<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CebuLink+</title>
    <link rel="stylesheet" href="{{ asset('css/home_style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=M+PLUS+Rounded+1c:wght@700&display=swap"
        rel="stylesheet">
    @yield('styles')
</head>

<body>

    <div class="mobile-container">
        <header class="profile-header">

            <div style="display:flex; justify-content: space-between; " class="profile-right">
                <h1 class="logo">CebuLink+</h1>
                <button class="menu-toggle">☰</button>

            </div>
        </header>
        <main class="main-content">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

</body>

</html>
