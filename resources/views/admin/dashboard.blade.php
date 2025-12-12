@extends('admin.layouts.app')

@section('title', 'Панель администратора')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-tachometer-alt"></i> Панель администратора
        </h1>
        <span class="badge bg-success">
        <i class="fas fa-user-shield"></i> Администратор
    </span>
    </div>

    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Товары</h5>
                    <h2 class="text-primary">{{ \App\Models\Product::count() }}</h2>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                        Управление
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Пользователи</h5>
                    <h2 class="text-success">{{ \App\Models\User::count() }}</h2>
                    <a href="#" class="btn btn-sm btn-outline-success">
                        Управление
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Заказы</h5>
                    <h2 class="text-warning">{{ \App\Models\Order::count() ?? 0 }}</h2>
                    <a href="#" class="btn btn-sm btn-outline-warning">
                        Управление
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h5 class="card-title">Доход</h5>
                    <h2 class="text-info">{{ number_format(\App\Models\Order::sum('total') ?? 0, 0, ',', ' ') }} ₽</h2>
                    <a href="#" class="btn btn-sm btn-outline-info">
                        Отчет
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Быстрые действия</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('admin.products.create') }}" class="card text-decoration-none text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-plus-circle fa-3x text-success"></i>
                        </div>
                        <h6>Добавить товар</h6>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('admin.products.index') }}" class="card text-decoration-none text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-edit fa-3x text-primary"></i>
                        </div>
                        <h6>Редактировать товары</h6>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('home') }}" target="_blank" class="card text-decoration-none text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-external-link-alt fa-3x text-dark"></i>
                        </div>
                        <h6>Перейти на сайт</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
