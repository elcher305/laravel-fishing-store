{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Личный кабинет</h4>
        </div>
        <div class="card-body">
            <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
            <p>Ваш email: {{ Auth::user()->email }}</p>
            <p>Дата регистрации: {{ Auth::user()->created_at->format('d.m.Y') }}</p>

            <div class="mt-4">
                <h6>Ваши данные:</h6>
                <ul>
                    <li>Имя: {{ Auth::user()->name }}</li>
                    <li>Email: {{ Auth::user()->email }}</li>
                    <li>ID: {{ Auth::user()->id }}</li>
                </ul>
            </div>

            <a href="/" class="btn btn-primary">На главную</a>
        </div>
    </div>
@endsection
