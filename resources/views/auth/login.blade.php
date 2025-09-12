@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
<div class="login-container">
    <h1 class="logo">CebuLink+</h1>

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <!-- ユーザー名 or Email -->
        <input id="email" type="text"
            class="@error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}"
            required autofocus placeholder="ユーザー ネーム">

        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- パスワード -->
        <input id="password" type="password"
            class="@error('password') is-invalid @enderror"
            name="password" required placeholder="パスワード">

        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- ボタン -->
        <div class="button-group">
            <a href="{{ url('/') }}" class="btn-cancel">cancel</a>
            <button type="submit" class="btn-login">Login</button>
        </div>
    </form>
</div>
@endsection
