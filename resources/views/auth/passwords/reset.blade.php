<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новый пароль</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-layout.css') }}">
</head>
<body class="reset-page">
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Новый пароль</h1>

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    class="form-input"
                    required
                    autofocus
                >
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Новый пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    required
                >
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Подтвердите пароль</label>
                <input
                    type="password"
                    id="password-confirm"
                    name="password_confirmation"
                    class="form-input"
                    required
                >
            </div>

            <button type="submit" class="auth-button">
                Установить новый пароль
            </button>
        </form>

        <div class="auth-divider">
            <span>или</span>
        </div>

        <a href="{{ route('login') }}" class="link-button">
            Войти в аккаунт
        </a>
    </div>
</div>
</body>
</html>
