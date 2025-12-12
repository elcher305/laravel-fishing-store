<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сброс пароля</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="reset-page">
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Восстановление пароля</h1>

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input"
                    placeholder="Введите ваш email"
                    required
                    autofocus
                >
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                Отправить ссылку для сброса
            </button>
        </form>

        <div class="auth-divider">
            <span>или</span>
        </div>

        <a href="{{ route('login') }}" class="link-button">
            Войти в аккаунт
        </a>

        <a href="{{ route('register') }}" class="link-button mt-2">
            Регистрация
        </a>
    </div>
</div>
</body>
</html>
