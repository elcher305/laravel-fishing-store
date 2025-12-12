<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой профиль</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="profile-card">
        <div class="profile-header">
            <h1 class="profile-title">Мой профиль</h1>
            <span class="role-badge" style="
                    background: {{ Auth::user()->isAdmin() ? '#3498db' : '#2ecc71' }};
                    color: white;
                    padding: 6px 12px;
                    border-radius: 20px;
                    font-size: 14px;
                    font-weight: 500;
                ">
                    {{ Auth::user()->isAdmin() ? 'Администратор' : 'Пользователь' }}
                </span>
        </div>

        <div class="profile-info">
            <div class="info-group">
                <span class="info-label">Имя пользователя:</span>
                <span class="info-value">{{ Auth::user()->name }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Email адрес:</span>
                <span class="info-value">{{ Auth::user()->email }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Телефон:</span>
                <span class="info-value">{{ Auth::user()->phone ?? 'Не указан' }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Роль:</span>
                <span class="info-value">{{ Auth::user()->role->description }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Дата регистрации:</span>
                <span class="info-value">{{ Auth::user()->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>

        <div class="profile-actions">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                Редактировать профиль
            </a>

            <a href="{{ route('profile.change-password') }}" class="btn btn-secondary">
                Сменить пароль
            </a>

            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Выйти
                </button>
            </form>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    Панель администратора
                </a>
            @endif
        </div>

        <a href="{{ url('/dashboard') }}" class="back-link">
            ← Вернуться на главную
        </a>
    </div>
</div>
</body>
</html>
