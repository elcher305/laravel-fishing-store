{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Восстановление пароля</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Отправить ссылку для сброса</button>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">← Вернуться ко входу</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
