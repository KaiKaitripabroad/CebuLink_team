<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CebuLink+</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
    <div class="app-background-container">
        <div class="background-gradient"></div>
        <img class="palm-tree" src="images/palm-tree-silhouette.png"></img>

        <div class="content-wrapper">
            <div class="logo">
                <a href="#">CebuLink+</a>
            </div>

            <div class="description-text">
                <p>Choose your account</p>
            </div>

            <div class="buttons-container">
                <a href="{{ route('login') }}" class="button login-button">Login</a>
                <a href="{{ route('register') }}" class="button signup-button">sign up</a>
            </div>
            <div class="guest-button-container">
                <a href="{{ route('guest.index') }}" class="button guest-button">guest</a>
            </div>
        </div>
    </div>
</body>

</html>
