@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
    <div class="card">
        <h2>Восстановление пароля</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit">Отправить ссылку для сброса</button>

            <p style="margin-top: 15px;">
                <a href="{{ route('login') }}">Вернуться к входу</a>
            </p>
        </form>
    </div>
@endsection
