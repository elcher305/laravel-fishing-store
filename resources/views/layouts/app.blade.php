<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold">Личный кабинет</a>
        <div>
            @auth
                <span class="mr-4">Привет, {{ Auth::user()->name }}!</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">Войти</a>
                <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded ml-2">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

<main class="container mx-auto mt-8 p-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
