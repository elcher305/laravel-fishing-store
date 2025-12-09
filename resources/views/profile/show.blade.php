@extends('layouts.app')

@section('title', 'Мой профиль')

@section('content')
    <div class="profile-layout">
        <!-- Сайдбар -->
        <div class="sidebar">
            <h3>Меню</h3>
            <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
                📋 Мой профиль
            </a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                ✏️ Редактировать профиль
            </a>
            <a href="{{ route('profile.orders') }}" class="{{ request()->routeIs('profile.orders') ? 'active' : '' }}">
                📦 Мои заказы
            </a>
            <a href="{{ route('profile.change-password') }}" class="{{ request()->routeIs('profile.change-password') ? 'active' : '' }}">
                🔐 Изменить пароль
            </a>
        </div>

        <!-- Основной контент -->
        <div class="content">
            <div class="card">
                <h2>Мой профиль</h2>

                <div class="profile-info">
                    <div style="display: flex; align-items: center; margin-bottom: 30px;">
                        <div style="width: 100px; height: 100px; background: #007bff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                        <span style="color: white; font-size: 40px; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        </div>
                        <div>
                            <h3 style="margin: 0;">{{ Auth::user()->name }}</h3>
                            <p style="color: #666; margin: 5px 0;">{{ Auth::user()->email }}</p>
                            <p style="color: #888; font-size: 14px;">
                                Зарегистрирован: {{ Auth::user()->created_at->format('d.m.Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <h4>Контактная информация</h4>
                                <p><strong>Телефон:</strong> {{ Auth::user()->phone ?? 'Не указан' }}</p>
                                <p><strong>Адрес:</strong> {{ Auth::user()->address ?? 'Не указан' }}</p>
                            </div>

                            <div>
                                <h4>Статистика</h4>
                                <p><strong>Всего заказов:</strong> {{ $user->orders()->count() ?? 0 }}</p>
                                <p><strong>Последний вход:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 10px;">
                        <a href="{{ route('profile.edit') }}" class="btn">Редактировать профиль</a>
                        <a href="{{ route('profile.change-password') }}" class="btn btn-success">Изменить пароль</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
