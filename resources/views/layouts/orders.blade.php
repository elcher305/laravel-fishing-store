<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Profile System')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }

        /* Навигация */
        .navbar { background: #333; color: white; padding: 15px 0; }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { text-decoration: underline; }

        /* Сайдбар и контент */
        .profile-layout { display: flex; gap: 30px; margin-top: 20px; }
        .sidebar { width: 250px; background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .sidebar a { display: block; padding: 10px; margin: 5px 0; text-decoration: none; color: #333; border-radius: 4px; }
        .sidebar a:hover { background: #f0f0f0; }
        .sidebar a.active { background: #007bff; color: white; }
        .content { flex: 1; }

        /* Карточки */
        .card { background: white; border-radius: 8px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { margin-bottom: 20px; color: #333; }

        /* Формы */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group textarea { min-height: 100px; resize: vertical; }

        /* Кнопки */
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 16px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }

        /* Уведомления */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Таблица */
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .table tr:hover { background: #f5f5f5; }

        /* Статусы заказов */
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 14px; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <a href="/" style="color: white; text-decoration: none; font-size: 20px; font-weight: bold;">
                Profile System
            </a>
        </div>
        <div class="nav-links">
            @auth
                <span>Привет, {{ Auth::user()->name }}!</span>
                <a href="{{ route('dashboard') }}">Главная</a>
                <a href="{{ route('profile.show') }}">Профиль</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 14px;">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Войти</a>
                <a href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
