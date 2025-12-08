{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Вход в систему</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">Войти</button>

                        <div class="text-center mt-3">
                            Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a><br>
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
