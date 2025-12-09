@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')
    <div class="card">
        <h2>Сброс пароля</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
            </div>

            <div class="form-group">
                <label>Новый пароль:</label>
                <input type="password" name="password" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Подтверждение пароля:</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Сбросить пароль</button>
        </form>
    </div>
@endsection
