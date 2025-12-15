<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="welcome">Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->email }}</span>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Профиль</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </div>

    <div class="nav">
        <a href="{{ route('profile.edit') }}">Редактировать профиль</a>
        <a href="{{ route('profile.change-password') }}">Сменить пароль</a>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">Панель администратора</a>
        @endif
    </div>

    <div class="content">
        <h2>Панель управления</h2>
        <p>Вы успешно авторизованы в системе.</p>

        <div style="margin-top: 30px;">
            <h3>Быстрые действия:</h3>
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
                <a href="{{ route('profile.change-password') }}" class="btn btn-secondary">Сменить пароль</a>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3>Администраторские функции:</h3>
                <p>У вас есть права администратора. Вы можете:</p>
                <ul>
                    <li>Управлять пользователями</li>
                    <li>Настраивать систему</li>
                    <li>Просматривать статистику</li>
                </ul>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Перейти в панель администратора</a>
            </div>
        @endif
    </div>
</div>
</body>
</html>
