<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог рыболовных снастей</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<!-- Шапка -->
<header class="bg-blue-800 text-white">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">🎣 Рыболовный Мир</h1>
            <nav class="flex gap-6">
                <a href="{{ route('catalog.index') }}" class="hover:text-blue-200">Каталог</a>
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
                <h3 class="text-lg font-bold mb-4">Фильтры</h3>

                <!-- Поиск -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('catalog.index') }}">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Поиск снастей..."
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <button type="submit" class="absolute right-2 top-2 text-gray-400">
                                🔍
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Категории -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Категории</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   onchange="this.form.submit()" class="mr-2">
                            <span>Все категории</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center">
                                <input type="radio" name="category" value="{{ $cat->id }}"
                                       {{ request('category') == $cat->id ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-2">
                                <span>{{ $cat->name }} ({{ $cat->products_count }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Бренды -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Бренды</h4>
                    <div class="space-y-2">
                        @foreach($brandsList as $brand)
                            <label class="flex items-center">
                                <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                       {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-2">
                                <span>{{ $brand->name }} ({{ $brand->products_count }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Цена -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Цена, руб.</h4>
                    <div class="flex gap-2 mb-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                               placeholder="От" class="w-1/2 px-2 py-1 border rounded text-sm"
                               onchange="this.form.submit()">
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                               placeholder="До" class="w-1/2 px-2 py-1 border rounded text-sm"
                               onchange="this.form.submit()">
                    </div>
                    <div class="text-xs text-gray-500">
                        Макс: {{ number_format($maxProductPrice, 0, ',', ' ') }} руб.
                    </div>
                </div>

                <!-- Рейтинг -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Рейтинг</h4>
                    <div class="space-y-2">
                        @for($i = 5; $i >= 1; $i--)
                            <label class="flex items-center">
                                <input type="radio" name="min_rating" value="{{ $i }}"
                                       {{ request('min_rating') == $i ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="mr-2">
                                <div class="flex text-yellow-400">
                                    @for($j = 1; $j <= 5; $j++)
                                        @if($j <= $i)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 ml-2">и выше</span>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Наличие -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="in_stock" value="1"
                               {{ request('in_stock') ? 'checked' : '' }}
                               onchange="this.form.submit()" class="mr-2">
                        <span>Только в наличии</span>
                    </label>
                </div>

                <!-- Сброс фильтров -->
                <a href="{{ route('catalog.index') }}"
                   class="block w-full bg-gray-500 text-white text-center py-2 rounded hover:bg-gray-600">
                    Сбросить фильтры
                </a>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="lg:w-3/4">
            <!-- Заголовок и сортировка -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold">Каталог рыболовных снастей</h1>
                        <p class="text-gray-600">Найдено товаров: {{ $products->total() }}</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Сортировка:</span>
                        <select name="sort" onchange="updateSort(this.value)"
                                class="border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>По новизне</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена по возрастанию</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена по убыванию</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>По популярности</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Сетка товаров -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('catalog.show', $product->slug) }}">
                                <img src="{{ $product->image ?: '/images/placeholder.jpg' }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover">
                            </a>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('catalog.show', $product->slug) }}"
                                       class="font-semibold text-lg hover:text-blue-600 line-clamp-2 flex-1">
                                        {{ $product->name }}
                                    </a>
                                </div>

                                <div class="mb-2">
                                    <span class="text-gray-500 text-sm">{{ $product->brand->name }}</span>
                                </div>

                                <!-- Рейтинг -->
                                <div class="flex items-center mb-3">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-600 text-sm ml-2">
                                    ({{ $product->review_count }})
                                </span>
                                </div>

                                <!-- Цена -->
                                <div class="flex items-center justify-between">
                                    <div>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                                    </span>
                                        @if($product->old_price)
                                            <span class="text-lg text-gray-500 line-through ml-2">
                                        {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Наличие -->
                                <div class="mt-3">
                                    @if($product->in_stock)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                    ✓ В наличии
                                </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">
                                    Нет в наличии
                                </span>
                                    @endif
                                </div>

                                <!-- Кнопка корзины -->
                                <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <h3 class="text-xl font-semibold mb-4">Товары не найдены</h3>
                    <p class="text-gray-600 mb-4">Попробуйте изменить параметры фильтрации</p>
                    <a href="{{ route('catalog.index') }}"
                       class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Сбросить фильтры
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

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
