@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="card">
        <h2>Вход в систему</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Войти</button>

            <p style="margin-top: 15px;">
                <a href="{{ route('password.request') }}">Забыли пароль?</a> |
                <a href="{{ route('register') }}">Регистрация</a>
            </p>
        </form>
    </div>
@endsection
