<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body>
<div class="profile-container">
    <div class="profile-card">
        <h1 class="profile-title">Редактирование профиля</h1>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul style="color: #e74c3c; font-size: 14px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="auth-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Имя пользователя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', Auth::user()->name) }}"
                    class="form-input"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email адрес</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    class="form-input"
                    required
                >
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Телефон</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', Auth::user()->phone) }}"
                    class="form-input"
                    placeholder="+7 (999) 123-45-67"
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Сохранить изменения
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
