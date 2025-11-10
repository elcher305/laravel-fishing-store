@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Регистрация</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="name">Имя</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Пароль</label>
                <input type="password" name="password" id="password"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="password_confirmation">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Зарегистрироваться
            </button>

            <p class="mt-4 text-center">
                Уже есть аккаунт? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Войти</a>
            </p>
        </form>
    </div>
@endsection
