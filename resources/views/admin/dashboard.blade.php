<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">

</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="admin-title">Панель администратора</h1>
        <div class="nav">
            <a href="{{ route('dashboard') }}">На главную</a>
            <a href="{{ route('profile.show') }}">Профиль</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="
                        padding: 10px 20px;
                        background: #f8f9fa;
                        color: #e74c3c;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        cursor: pointer;
                        font-family: inherit;
                        font-size: inherit;
                    ">Выйти</button>
            </form>
        </div>
    </div>

    <div class="content">
        <h2>Добро пожаловать, Администратор!</h2>
        <p>Вы вошли в панель администратора системы.</p>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\User::count() }}</div>
                <div class="stat-label">Всего пользователей</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\User::where('role_id', 1)->count() }}</div>
                <div class="stat-label">Администраторов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\User::where('role_id', 2)->count() }}</div>
                <div class="stat-label">Обычных пользователей</div>
            </div>
        </div>

        <div class="admin-section">
            <h3>Быстрые действия</h3>
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <a href="{{ route('profile.show') }}" class="btn btn-primary">Мой профиль</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">На главную</a>
            </div>
        </div>

        <div class="admin-section">
            <h3>Системная информация</h3>
        </div>
    </div>
</div>
</body>
</html>
