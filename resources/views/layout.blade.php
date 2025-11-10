<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Админпанель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-blue-800 text-white shadow-lg">
        <div class="p-4">
            <h1 class="text-2xl font-bold">🎣 Админпанель</h1>
            <p class="text-blue-200 text-sm">Рыболовный Мир</p>
        </div>

        <nav class="mt-8">
            <a href="{{ route('admin.dashboard') }}"
               class="block py-3 px-6 hover:bg-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 border-r-4 border-yellow-400' : '' }}">
                📊 Дашборд
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="block py-3 px-6 hover:bg-blue-700 {{ request()->routeIs('admin.products.*') ? 'bg-blue-700 border-r-4 border-yellow-400' : '' }}">
                🎣 Товары
            </a>
            <a href="/" class="block py-3 px-6 hover:bg-blue-700 mt-8 border-t border-blue-700">
                🏪 Вернуться в магазин
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="flex justify-between items-center px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Администратор</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
