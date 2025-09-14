@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
<div class="register-container">
    <h1 class="logo">CebuLink+</h1>

    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <!-- ユーザー名 -->
        <input id="name" type="text"
            class="@error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}"
            required autocomplete="name" autofocus
            placeholder="ユーザー ネーム">

        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- Email -->
        <input id="email" type="email"
            class="@error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}"
            required autocomplete="email"
            placeholder="E-mail">

        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- Password -->
        <input id="password" type="password"
            class="@error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password"
            placeholder="パスワード">

        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror

        <!-- Confirm Password -->
        <input id="password-confirm" type="password"
            name="password_confirmation" required autocomplete="new-password"
            placeholder="確認用パスワード">

        <!-- ボタン -->
        <div class="button-group">
            <a href="{{ url('/') }}" class="btn-cancel">cancel</a>
            <button type="submit" class="btn-signup">sign up</button>
        </div>
    </form>
</div>
@endsection
