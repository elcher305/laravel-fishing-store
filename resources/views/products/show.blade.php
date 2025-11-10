<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} -CatFish</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
<!-- Шапка -->
<header class="bg-blue-800 text-white">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">CatFish</a>
            <nav class="flex gap-6">
                <a href="{{ route('catalog.index') }}" class="hover:text-blue-200">Каталог</a>
                <a href="#" class="hover:text-blue-200">Доставка</a>
                <a href="#" class="hover:text-blue-200">Контакты</a>
            </nav>
        </div>
    </div>
</header>

<div class="container mx-auto px-4 py-8">
    <!-- Хлебные крошки -->
    <nav class="flex mb-6 text-sm" aria-label="Хлебные крошки">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('catalog.index') }}" class="text-blue-600 hover:text-blue-800">Каталог</a>
            </li>
            <li class="flex items-center">
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}"
                   class="text-blue-600 hover:text-blue-800">{{ $product->category->name }}</a>
            </li>
            <li class="flex items-center">
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-500">{{ $product->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Основная информация о товаре -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
            <!-- Галерея изображений -->
            <div x-data="{ activeImage: 0 }">
                <!-- Основное изображение -->
                <div class="mb-4">
                    <img x-bind:src="$el.querySelectorAll('img')[activeImage]?.src || '/images/placeholder-product.jpg'"
                         alt="{{ $product->name }}"
                         class="w-full h-96 object-contain rounded-lg bg-white">
                </div>

                <!-- Миниатюры -->
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->all_images as $index => $image)
                        <button @click="activeImage = {{ $index }}"
                                :class="activeImage === {{ $index }} ? 'ring-2 ring-blue-500' : ''"
                                class="p-1 border rounded hover:border-blue-500 transition-colors">
                            <img src="{{ $image }}"
                                 alt="{{ $product->name }} - изображение {{ $index + 1 }}"
                                 class="w-full h-20 object-contain">
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Информация о товаре -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

                <!-- Рейтинг и отзывы -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 text-xl mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($ratingStats['average']))
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-600 mr-4">{{ $ratingStats['average'] }} / 5</span>
                    <a href="#reviews" class="text-blue-600 hover:text-blue-800">
                        {{ $ratingStats['count'] }} {{ trans_choice('отзыв|отзыва|отзывов', $ratingStats['count']) }}
                    </a>
                </div>

                <!-- Бренд и категория -->
                <div class="mb-6 space-y-2">
                    <div>
                        <span class="text-gray-600">Бренд: </span>
                        <a href="{{ route('catalog.index', ['brands[]' => $product->brand_id]) }}"
                           class="text-blue-600 hover:text-blue-800 font-semibold">{{ $product->brand->name }}</a>
                    </div>
                    <div>
                        <span class="text-gray-600">Категория: </span>
                        <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}"
                           class="text-blue-600 hover:text-blue-800">{{ $product->category->name }}</a>
                    </div>
                </div>

                <!-- Цена -->
                <div class="mb-6">
                    <div class="flex items-baseline gap-4 mb-2">
                            <span class="text-4xl font-bold text-gray-900">
                                {{ number_format($product->price, 0, ',', ' ') }} ₽
                            </span>
                        @if($product->has_discount)
                            <div class="flex flex-col">
                                <span class="text-2xl text-gray-500 line-through">
                                    {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                                </span>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-semibold">
                                    -{{ $product->discount_percent }}%
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Наличие -->
                <div class="mb-6">
                    @if($product->in_stock)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-lg font-semibold">В наличии</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">Быстрая доставка 1-2 дня</p>
                    @else
                        <div class="flex items-center text-red-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-lg font-semibold">Нет в наличии</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">Ожидаем поставку</p>
                    @endif
                </div>

                <!-- Кнопки действий -->
                <div class="flex gap-4 mb-6">
                    @if($product->in_stock)
                        <button class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-lg">
                            Добавить в корзину
                        </button>
                    @else
                        <button disabled class="flex-1 bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold text-lg cursor-not-allowed">
                            Товар закончился
                        </button>
                    @endif
                    <button class="p-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-2xl">
                        ♡
                    </button>
                </div>

                <!-- Краткое описание -->
                @if($product->description)
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-lg mb-3">Описание</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Детальная информация -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Характеристики -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-6">Характеристики</h2>

                @if($product->features && count($product->features) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($product->features as $key => $value)
                            <div class="border-b pb-2">
                                <span class="font-semibold text-gray-700">{{ $key }}:</span>
                                <span class="text-gray-900 ml-2">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">Характеристики не указаны</p>
                @endif
            </div>
        </div>

        <!-- Статистика отзывов -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Рейтинг товара</h2>

            <div class="text-center mb-6">
                <div class="text-5xl font-bold text-blue-600 mb-2">{{ $ratingStats['average'] }}</div>
                <div class="flex justify-center text-yellow-400 text-xl mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($ratingStats['average']))
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <div class="text-gray-600">на основе {{ $ratingStats['count'] }} отзывов</div>
            </div>

            <!-- Распределение оценок -->
            <div class="space-y-2">
                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center">
                        <span class="w-8 text-sm text-gray-600">{{ $i }} ★</span>
                        <div class="flex-1 mx-2">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full"
                                     style="width: {{ $ratingStats['distribution'][5-$i] }}%"></div>
                            </div>
                        </div>
                        <span class="w-8 text-sm text-gray-600">{{ $ratingStats['distribution'][5-$i] }}%</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Отзывы -->
    <div id="reviews" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Отзывы покупателей</h2>
            @auth
                <button onclick="document.getElementById('reviewForm').classList.toggle('hidden')"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Написать отзыв
                </button>
            @else
                <a href="{{ route('login') }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Войти, чтобы оставить отзыв
                </a>
            @endauth
        </div>

        <!-- Форма отзыва -->
        @auth
            <div id="reviewForm" class="hidden mb-8 p-6 border rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Оставить отзыв</h3>
                <form action="{{ route('products.review.add', $product->slug) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Рейтинг -->
                        <div>
                            <label class="block text-gray-700 mb-2">Ваша оценка</label>
                            <div class="flex space-x-1" x-data="{ rating: 0 }">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            @click="rating = {{ $i }}"
                                            :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                            class="text-2xl focus:outline-none">
                                        ★
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" x-model="rating" required>
                            </div>
                        </div>

                        <!-- Комментарий -->
                        <div>
                            <label for="comment" class="block text-gray-700 mb-2">Комментарий *</label>
                            <textarea name="comment" id="comment" rows="4"
                                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                      placeholder="Поделитесь вашим опытом использования товара..." required></textarea>
                        </div>

                        <!-- Достоинства и недостатки -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="advantages" class="block text-gray-700 mb-2">Достоинства</label>
                                <textarea name="advantages" id="advantages" rows="3"
                                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                          placeholder="Что вам понравилось..."></textarea>
                            </div>
                            <div>
                                <label for="disadvantages" class="block text-gray-700 mb-2">Недостатки</label>
                                <textarea name="disadvantages" id="disadvantages" rows="3"
                                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                          placeholder="Что можно улучшить..."></textarea>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Отправить отзыв
                            </button>
                            <button type="button"
                                    onclick="document.getElementById('reviewForm').classList.add('hidden')"
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                                Отмена
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endauth

        <!-- Список отзывов -->
        @if($product->reviews->count() > 0)
            <div class="space-y-6">
                @foreach($product->reviews as $review)
                    <div class="border-b pb-6 last:border-b-0">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="font-semibold text-lg">{{ $review->user->name }}</span>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400 mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-sm">{{ $review->formatted_date }}</span>
                                </div>
                            </div>
                        </div>

                        @if($review->advantages || $review->disadvantages)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                @if($review->advantages)
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="font-semibold text-green-800 mb-1">Достоинства:</div>
                                        <div class="text-green-700">{{ $review->advantages }}</div>
                                    </div>
                                @endif
                                @if($review->disadvantages)
                                    <div class="bg-red-50 p-3 rounded-lg">
                                        <div class="font-semibold text-red-800 mb-1">Недостатки:</div>
                                        <div class="text-red-700">{{ $review->disadvantages }}</div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 text-6xl mb-4">💬</div>
                <h3 class="text-xl font-semibold mb-2">Пока нет отзывов</h3>
                <p class="text-gray-600">Будьте первым, кто оставит отзыв об этом товаре!</p>
            </div>
        @endif
    </div>

    <!-- Похожие товары -->
    @if($relatedProducts->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Похожие товары</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}">
                            <img src="{{ $relatedProduct->image ?: '/images/placeholder-product.jpg' }}"
                                 alt="{{ $relatedProduct->name }}"
                                 class="w-full h-48 object-contain p-4">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}"
                               class="font-semibold hover:text-blue-600 line-clamp-2 mb-2 block">
                                {{ $relatedProduct->name }}
                            </a>
                            <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">
                                {{ number_format($relatedProduct->price, 0, ',', ' ') }} ₽
                            </span>
                            </div>
                            @if($relatedProduct->in_stock)
                                <span class="text-green-600 text-sm">✓ В наличии</span>
                            @else
                                <span class="text-red-600 text-sm">Нет в наличии</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button onclick="addToCart({{ $product->id }})"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
            В корзину
        </button>

        <script>
            async function addToCart(productId) {
                try {
                    const response = await fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ product_id: productId })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Обновляем счетчик корзины в шапке
                        updateCartHeader(data.cart);

                        // Показываем уведомление
                        showNotification('Товар добавлен в корзину', 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Произошла ошибка при добавлении в корзину', 'error');
                }
            }

            function updateCartHeader(cart) {
                // Обновляем счетчик в шапке
                let cartCounter = document.querySelector('nav a[href*="cart"] span');
                if (!cartCounter) {
                    const cartLink = document.querySelector('nav a[href*="cart"]');
                    cartCounter = document.createElement('span');
                    cartCounter.className = 'ml-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center';
                    cartLink.appendChild(cartCounter);
                }
                cartCounter.textContent = cart.items_count;
            }

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>
    @endif
</div>

<!-- Футер -->
<footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center">
            <p>🎣 Рыболовный Мир &copy; 2024. Все права защищены.</p>
        </div>
    </div>
</footer>

<!-- Сообщения -->
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
@endif
</body>
</html>
