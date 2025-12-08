<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления - Fishing Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">🎣 Fishing Store</a>
        <div class="navbar-nav ms-auto">
            @auth
                <span class="nav-item nav-link">Привет, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Выйти</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Вход</a>
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Панель управления</h4>
        </div>
        <div class="card-body">
            @auth
                <div class="row">
                    <div class="col-md-6">
                        <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
                        <p>Email: {{ Auth::user()->email }}</p>
                        <p>Дата регистрации: {{ Auth::user()->created_at->format('d.m.Y') }}</p>

                        <div class="mt-4">
                            <h6>Быстрые ссылки:</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-success me-2">
                                📦 Управление товарами
                            </a>
                            <a href="/" class="btn btn-outline-primary">
                                🏠 На главную
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>Статистика</h6>
                                <p>Тут может быть статистика вашего магазина</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <h5>Вы не авторизованы</h5>
                    <p>Пожалуйста, войдите в систему</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Регистрация</a>
                </div>
            @endauth
        </div>
    </div>
</div>
</body>
</html>
