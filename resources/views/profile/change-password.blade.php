<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Смена пароля</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body>
<div class="profile-container">
    <div class="profile-card">
        <h1 class="profile-title">Смена пароля</h1>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul style="color: #e74c3c; font-size: 14px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.change-password.update') }}" class="auth-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password" class="form-label">Текущий пароль</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-input"
                    required
                >
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
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-input"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Сменить пароль
                </button>

                <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
