<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - CatFish</title>
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
                <a href="{{ route('cart.index') }}" class="hover:text-blue-200 flex items-center">
                    🛒 Корзина
                    @if($items_count > 0)
                        <span class="ml-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">
                            {{ $items_count }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>
    </div>
</header>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Корзина покупок</h1>

    @if($items_count > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Список товаров -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    @foreach($items as $item)
                        <div class="flex items-center p-6 border-b last:border-b-0"
                             x-data="{ quantity: {{ $item->quantity }}, updating: false }">
                            <!-- Изображение товара -->
                            <div class="flex-shrink-0 w-24 h-24 mr-4">
                                <img src="{{ $item->product->image ?: '/images/placeholder-product.jpg' }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-full object-contain">
                            </div>

                            <!-- Информация о товаре -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg mb-2">
                                    <a href="{{ route('products.show', $item->product->slug) }}"
                                       class="hover:text-blue-600">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $item->product->brand->name }}</p>

                                <!-- Наличие -->
                                @if($item->product->in_stock)
                                    <span class="text-green-600 text-sm">✓ В наличии</span>
                                @else
                                    <span class="text-red-600 text-sm">Нет в наличии</span>
                                @endif
                            </div>

                            <!-- Управление количеством -->
                            <div class="flex items-center space-x-3 mr-6">
                                <button @click="if(quantity > 1) {
                                quantity--;
                                updating = true;
                                $nextTick(() => updateQuantity({{ $item->product_id }}, quantity));
                            }"
                                        :disabled="quantity <= 1"
                                        class="w-8 h-8 flex items-center justify-center border rounded bg-gray-100 hover:bg-gray-200 disabled:opacity-50">
                                    −
                                </button>

                                <span x-text="quantity" class="w-12 text-center font-semibold"></span>

                                <button @click="
                                quantity++;
                                updating = true;
                                $nextTick(() => updateQuantity({{ $item->product_id }}, quantity));"
                                        class="w-8 h-8 flex items-center justify-center border rounded bg-gray-100 hover:bg-gray-200">
                                    +
                                </button>
                            </div>

                            <!-- Цена -->
                            <div class="text-right mr-6">
                                <div class="text-xl font-bold text-gray-900">
                                    <span x-text="formatPrice({{ $item->price }} * quantity)"></span> ₽
                                </div>
                                <div class="text-gray-500 text-sm">
                                    {{ number_format($item->price, 0, ',', ' ') }} ₽/шт
                                </div>
                            </div>

                            <!-- Удаление -->
                            <button onclick="removeItem({{ $item->product_id }})"
                                    class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>

                            <!-- Индикатор загрузки -->
                            <div x-show="updating" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Очистка корзины -->
                <div class="mt-4 text-right">
                    <button onclick="clearCart()"
                            class="text-red-600 hover:text-red-800 font-semibold">
                        Очистить корзину
                    </button>
                </div>
            </div>

            <!-- Итоги -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Итоги заказа</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span>Товары ({{ $items_count }})</span>
                            <span>{{ number_format($total_amount, 0, ',', ' ') }} ₽</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Доставка</span>
                            <span class="text-green-600">Бесплатно</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Итого</span>
                                <span>{{ number_format($total_amount, 0, ',', ' ') }} ₽</span>
                            </div>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-lg">
                        Перейти к оформлению
                    </button>

                    <p class="text-gray-600 text-sm text-center mt-4">
                        Бесплатная доставка при заказе от 5 000 ₽
                    </p>
                </div>

                <!-- Промокод -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="font-semibold mb-3">Промокод</h3>
                    <div class="flex">
                        <input type="text" placeholder="Введите промокод"
                               class="flex-1 px-3 py-2 border rounded-l-lg focus:outline-none focus:border-blue-500">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-r-lg hover:bg-gray-900">
                            Применить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Пустая корзина -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-gray-400 text-8xl mb-6">🛒</div>
            <h2 class="text-2xl font-bold mb-4">Ваша корзина пуста</h2>
            <p class="text-gray-600 mb-8">Добавьте товары из каталога, чтобы сделать заказ</p>
            <a href="{{ route('catalog.index') }}"
               class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg">
                Перейти в каталог
            </a>
        </div>
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

<!-- JavaScript -->
<script>
    function formatPrice(price) {
        return new Intl.NumberFormat('ru-RU').format(Math.round(price));
    }

    async function updateQuantity(productId, quantity) {
        try {
            const response = await fetch(`/cart/update/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity })
            });

            const data = await response.json();

            if (data.success) {
                // Обновляем счетчик корзины в шапке
                updateCartHeader(data.cart);
            } else {
                alert(data.message);
                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка при обновлении корзины');
            location.reload();
        }
    }

    async function removeItem(productId) {
        if (!confirm('Удалить товар из корзины?')) return;

        try {
            const response = await fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Обновляем счетчик корзины
                updateCartHeader(data.cart);
                // Перезагружаем страницу для обновления списка
                location.reload();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка при удалении товара');
        }
    }

    async function clearCart() {
        if (!confirm('Очистить всю корзину?')) return;

        try {
            const response = await fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                updateCartHeader({ items_count: 0, total_amount: 0 });
                location.reload();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка при очистке корзины');
        }
    }

    function updateCartHeader(cart) {
        // Обновляем счетчик в шапке
        const cartCounter = document.querySelector('nav a[href*="cart"] span');
        if (cartCounter) {
            if (cart.items_count > 0) {
                cartCounter.textContent = cart.items_count;
                cartCounter.classList.remove('hidden');
            } else {
                cartCounter.classList.add('hidden');
            }
        }
    }

    // Инициализация Alpine.js
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartItem', () => ({
            quantity: 1,
            updating: false
        }));
    });
</script>
</body>
</html>
