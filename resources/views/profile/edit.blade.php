@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
    <div class="profile-layout">
        <!-- Сайдбар -->
        <div class="sidebar">
            <h3>Меню</h3>
            <a href="{{ route('profile.show') }}">📋 Мой профиль</a>
            <a href="{{ route('profile.edit') }}" class="active">✏️ Редактировать профиль</a>
            <a href="{{ route('profile.orders') }}">📦 Мои заказы</a>
            <a href="{{ route('profile.change-password') }}">🔐 Изменить пароль</a>
        </div>

        <!-- Основной контент -->
        <div class="content">
            <div class="card">
                <h2>Редактирование профиля</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                               placeholder="+7 (XXX) XXX-XX-XX">
                    </div>

                    <div class="form-group">
                        <label for="address">Адрес</label>
                        <textarea id="address" name="address" placeholder="Введите ваш адрес">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn">Сохранить изменения</button>
                        <a href="{{ route('profile.show') }}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
