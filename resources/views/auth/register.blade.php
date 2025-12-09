@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="card">
        <h2>Регистрация</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Имя:</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

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

            <div class="form-group">
                <label>Подтверждение пароля:</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Зарегистрироваться</button>

            <p style="margin-top: 15px;">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </p>
        </form>
    </div>
@endsection
