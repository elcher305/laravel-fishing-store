@extends('layouts.app')

@section('title', 'Изменение пароля')

@section('content')
    <div class="profile-layout">
        <!-- Сайдбар -->
        <div class="sidebar">
            <h3>Меню</h3>
            <a href="{{ route('profile.show') }}">📋 Мой профиль</a>
            <a href="{{ route('profile.edit') }}">✏️ Редактировать профиль</a>
            <a href="{{ route('profile.orders') }}">📦 Мои заказы</a>
            <a href="{{ route('profile.change-password') }}" class="active">🔐 Изменить пароль</a>
        </div>

        <!-- Основной контент -->
        <div class="content">
            <div class="card">
                <h2>Изменение пароля</h2>

                <form method="POST" action="{{ route('profile.change-password') }}">
                    @csrf

                    <div class="form-group">
                        <label for="current_password">Текущий пароль</label>
                        <input type="password" id="current_password" name="current_password" required>
                        @error('current_password')
                        <span style="color: red; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">Новый пароль</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small style="color: #666;">Минимум 8 символов</small>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Подтверждение нового пароля</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-success">Изменить пароль</button>
                        <a href="{{ route('profile.show') }}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
