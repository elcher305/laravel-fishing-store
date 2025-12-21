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
                <button type="submit" class="nav-link btn btn-link text-start w-100">
                    <a class="fas fa-sign-out-alt"></a> Выйти
                </button>
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
        <p>Вы успешно авторизованы в системе администрирования.</p>


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
                    <li>Добавить товар</li>
                    <li>Управление товарами магазина</li>
                </ul>

            </div>
        @endif
        <div class="card-body">

            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-box-seam"></i> Товары
                            </h5>
                            <p class="card-text">Управление товарами магазина</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-light">
                                Перейти <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <h5>Быстрые действия:</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Добавить товар
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list"></i> Список товаров
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
