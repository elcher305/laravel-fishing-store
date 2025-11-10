<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог рыболовных снастей - CatFish</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
<!-- Шапка -->
<header class="bg-blue-800 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <a href="/" class="text-2xl font-bold flex items-center">
                CatFish
            </a>

            <!-- Поиск -->
            <form method="GET" action="{{ route('catalog.index') }}" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Поиск снастей..."
                           class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="absolute right-2 top-2 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <nav class="flex gap-6">
                <a href="{{ route('catalog.index') }}" class="hover:text-blue-200 font-semibold">Каталог</a>
                <a href="#" class="hover:text-blue-200">Доставка</a>
                <a href="#" class="hover:text-blue-200">Контакты</a>
            </nav>
        </div>
    </div>
</header>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Сайдбар с фильтрами -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Фильтры</h3>

                <!-- Категории -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-gray-700">Категории</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   onchange="this.form.submit()" class="mr-3">
                            <span class="text-gray-600">Все категории</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat->id }}"
                                       {{ request('category') == $cat->id ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-3">
                                <span class="text-gray-600 flex-1">{{ $cat->name }}</span>
                                <span class="text-gray-400 text-sm bg-gray-100 px-2 py-1 rounded">
                                    {{ $cat->products_count }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Бренды -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-gray-700">Бренды</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($brandsList as $brand)
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                       {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-3">
                                <span class="text-gray-600 flex-1">{{ $brand->name }}</span>
                                <span class="text-gray-400 text-sm bg-gray-100 px-2 py-1 rounded">
                                    {{ $brand->products_count }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Цена -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-gray-700">Цена, руб.</h4>
                    <div class="space-y-3">
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                   placeholder="От"
                                   class="w-1/2 px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                                   onchange="this.form.submit()">
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                   placeholder="До"
                                   class="w-1/2 px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                                   onchange="this.form.submit()">
                        </div>
                        <div class="text-xs text-gray-500 text-center">
                            Макс: {{ number_format($maxProductPrice, 0, ',', ' ') }} руб.
                        </div>
                    </div>
                </div>

                <!-- Рейтинг -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3 text-gray-700">Рейтинг</h4>
                    <div class="space-y-2">
                        @for($i = 5; $i >= 1; $i--)
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                <input type="radio" name="min_rating" value="{{ $i }}"
                                       {{ request('min_rating') == $i ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-3">
                                <div class="flex text-yellow-400 mr-2">
                                    @for($j = 1; $j <= 5; $j++)
                                        @if($j <= $i)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">и выше</span>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Наличие -->
                <div class="mb-6">
                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                        <input type="checkbox" name="in_stock" value="1"
                               {{ request('in_stock') ? 'checked' : '' }}
                               onchange="this.form.submit()" class="mr-3">
                        <span class="text-gray-600">Только в наличии</span>
                    </label>
                </div>

                <!-- Сброс фильтров -->
                <a href="{{ route('catalog.index') }}"
                   class="block w-full bg-gray-500 text-white text-center py-2 rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                    Сбросить фильтры
                </a>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="lg:w-3/4">
            <!-- Заголовок и сортировка -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Каталог рыболовных снастей</h1>
                        <p class="text-gray-600">
                            Найдено товаров: <span class="font-semibold">{{ $products->total() }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-gray-600 whitespace-nowrap">Сортировка:</span>
                        <select name="sort" onchange="updateSort(this.value)"
                                class="border rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>По новизне</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена по возрастанию</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена по убыванию</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>По популярности</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Сетка товаров -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <!-- Изображение -->
                            <a href="{{ $product->url }}" class="block relative">
                                <img src="{{ $product->all_images[0] }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">

                                <!-- Бейджи -->
                                <div class="absolute top-2 left-2 flex flex-col gap-1">
                                    @if($product->has_discount)
                                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                    -{{ $product->discount_percent }}%
                                </span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">
                                    Хит
                                </span>
                                    @endif
                                </div>
                            </a>

                            <!-- Информация о товаре -->
                            <div class="p-4">
                                <!-- Бренд -->
                                <div class="mb-2">
                                    <a href="{{ route('catalog.brand', $product->brand->slug) }}"
                                       class="text-gray-500 text-sm hover:text-blue-600">
                                        {{ $product->brand->name }}
                                    </a>
                                </div>

                                <!-- Название -->
                                <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                    <a href="{{ $product->url }}" class="text-gray-800 hover:text-blue-600">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <!-- Рейтинг -->
                                <div class="flex items-center mb-3">
                                    <div class="flex text-yellow-400 mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-sm">
                                    ({{ $product->review_count }})
                                </span>
                                </div>

                                <!-- Цена -->
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                                    </span>
                                        @if($product->has_discount)
                                            <span class="text-lg text-gray-500 line-through ml-2">
                                        {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Наличие и кнопка -->
                                <div class="flex items-center justify-between">
                                    @if($product->in_stock)
                                        <span class="text-green-600 text-sm font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    В наличии
                                </span>
                                    @else
                                        <span class="text-red-600 text-sm font-semibold">
                                    Нет в наличии
                                </span>
                                    @endif

                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-sm">
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Сообщение о пустом результате -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-gray-400 text-8xl mb-6">🎣</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Товары не найдены</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Попробуйте изменить параметры фильтрации или воспользуйтесь поиском
                    </p>
                    <a href="{{ route('catalog.index') }}"
                       class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg transition-colors">
                        Сбросить фильтры
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Футер -->
<footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center">
            <p class="text-lg"> CatFish </p>
            <p class="text-gray-400 mt-2">Все права защищены &copy; 2024</p>
        </div>
    </div>
</footer>

<!-- Скрытая форма для фильтрации -->
<form id="filterForm" method="GET" class="hidden">
    @foreach(request()->all() as $key => $value)
        @if($key != 'sort')
            @if(is_array($value))
                @foreach($value as $val)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $val }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endif
    @endforeach
</form>

<script>
    function updateSort(sortValue) {
        const form = document.getElementById('filterForm');
        const sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        sortInput.value = sortValue;
        form.appendChild(sortInput);
        form.submit();
    }
</script>
</body>
</html>
