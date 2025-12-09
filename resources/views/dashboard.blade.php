@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="card">
        <h1>Личный кабинет</h1>
        <p>Добро пожаловать, {{ Auth::user()->name }}!</p>
        <p>Ваш email: {{ Auth::user()->email }}</p>
        <p>Дата регистрации: {{ Auth::user()->created_at->format('d.m.Y') }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: #dc3545;">Выйти</button>
        </form>
    </div>
@endsection
