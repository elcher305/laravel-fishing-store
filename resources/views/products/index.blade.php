<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style-catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>

<main>
    <!-- Блок фильтрации товаров -->
    <section class="products-filter">
        <div class="container">
            <!-- Хлебные крошки -->
            <div class="breadcrumbs">
                <a href="{{ route('welcome') }}" class="breadcrumb-link">Главная</a>
                <span class="breadcrumb-separator">–</span>
                <span class="breadcrumb-current">Каталог товаров</span>
            </div>

            <div class="filter-container">
                <!-- Левая панель фильтров -->
                <aside class="filter-sidebar">
                    <h2 class="filter-title">Фильтры</h2>

                    <!-- Фильтр по цене -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Цена</h3>
                        <div class="price-options">
                            <label class="radio-option">
                                <input type="radio" name="price" value="low" {{ request('price') == 'low' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <span class="radio-label">До 1000 руб</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="price" value="medium" {{ request('price') == 'medium' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <span class="radio-label">1000 - 3000 руб</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="price" value="high" {{ request('price') == 'high' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <span class="radio-label">От 3000 руб</span>
                            </label>
                        </div>
                    </div>

                    <!-- Фильтр по категории -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Категория</h3>
                        <div class="checkbox-options">
                            <label class="checkbox-option">
                                <input type="checkbox" name="category_all" {{ empty(request('category')) ? 'checked' : '' }}>
                                <span class="checkbox-custom">✓</span>
                                <span class="checkbox-label">Все категории</span>
                            </label>
                            @foreach($categories as $category)
                                @if($category)
                                    <label class="checkbox-option">
                                        <input type="checkbox" name="category[]" value="{{ $category }}"
                                            {{ in_array($category, (array)request('category', [])) ? 'checked' : '' }}>
                                        <span class="checkbox-custom">✓</span>
                                        <span class="checkbox-label">{{ $category }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Фильтр по бренду -->
                    <div class="filter-group">
                        <h3 class="filter-group-title">Бренд</h3>
                        <div class="checkbox-options">
                            <label class="checkbox-option">
                                <input type="checkbox" name="brand_all" {{ empty(request('brand')) ? 'checked' : '' }}>
                                <span class="checkbox-custom">✓</span>
                                <span class="checkbox-label">Все бренды</span>
                            </label>

                        </div>
                    </div>

                    <!-- Кнопки фильтрации -->
                    <div class="filter-actions">
                        <button type="submit" form="filter-form" class="filter-btn apply-btn">показать</button>
                    </div>
                </aside>

                <div class="container">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif


                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="product-badge">{{ $product->category ?: 'ТОВАР' }}</div>
                                <div class="product-size">{{ $product->weight ? $product->weight . 'г' : '—' }}</div>

                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 200px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('img/no-image.png') }}" alt="Нет изображения" style="height: 200px; object-fit: contain;">
                                @endif


                                <div class="product-sizes">
                                    <span class="size-option">{{ $product->brand ?: 'Без бренда' }}</span>
                                </div>

                                <div class="product-stock {{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                                    @if($product->stock > 10)
                                        Есть в наличии
                                    @elseif($product->stock > 0)
                                        Осталось {{ $product->stock }}шт
                                    @else
                                        Нет в наличии
                                    @endif
                                </div>

                                <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <div class="quantity-selector">
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="quantity-input">
                                            <button type="submit" class="add-to-cart-btn">
                                                В корзину
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <button class="add-to-cart-btn" disabled>Нет в наличии</button>
                                @endif

                                @if($product->reviews_count > 0)
                                    <div style="margin-top: 10px; font-size: 14px; color: #666;">
                                         {{ number_format($product->average_rating, 1) }} ({{ $product->reviews_count }})
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="container">
                        <h1 class="best-products-title">Товары для летнее рыбалки</h1>

                        <div class="products-grid">
                            <!-- Товар 1 -->
                            <div class="product-card">
                                <div class="product-badge">ЗАВОДНОЕ</div>
                                <div class="product-size">SIZE #7</div>
                                <img src="img/spoon.png" alt="Кольцо">
                                <h3 class="product-name">Кольцо заводное Dunaev size #7</h3>

                                <div class="product-sizes">
                                    <span class="size-option">3.5мм</span>
                                    <span class="size-option">4мм</span>
                                    <span class="size-option">5мм</span>
                                    <span class="size-option">6мм</span>
                                    <span class="size-option">7мм</span>
                                </div>

                                <div class="product-stock in-stock">Есть в наличии</div>
                                <div class="product-price">100P</div>

                                <button class="add-to-cart-btn" >В корзину</button>
                            </div>

                            <!-- Товар 2 -->
                            <div class="product-card">
                                <div class="product-badge">ШНУР</div>
                                <div class="product-size">PE X4 150 м.</div>
                                <img src="img/Cord.png" alt="Шнур">
                                <h3 class="product-name">Шнур Дунаев Braid PE X4 150 м.</h3>

                                <div class="product-sizes">
                                    <span class="size-option">0.38мм</span>
                                    <span class="size-option">0.20мм</span>
                                    <span class="size-option">0.12мм</span>
                                    <span class="size-option">0.08мм</span>
                                </div>

                                <div class="product-stock low-stock">Осталось 2шт</div>
                                <div class="product-price">600P</div>

                                <button class="add-to-cart-btn">В корзину</button>
                            </div>

                            <!-- Товар 3 -->
                            <div class="product-card">
                                <div class="product-badge">ПРЕМИУМ</div>
                                <div class="product-size">Серия 107</div>
                                <img src="img/hooks.png" alt="Крючок">
                                <h3 class="product-name">Премиум крючок Дунаев </h3>

                                <div class="product-sizes">
                                    <span class="size-option">0.41мм</span>
                                    <span class="size-option">0.33мм</span>
                                    <span class="size-option">0.30мм</span>
                                    <span class="size-option">0.28мм</span>
                                </div>

                                <div class="product-stock out-of-stock">Нет в наличии</div>
                                <div class="product-price">145P</div>

                                <button class="add-to-cart-btn" disabled>Нет в наличии</button>
                            </div>

                            <!-- Товар 4 -->
                            <div class="product-card">
                                <div class="product-badge">ПРИКОРМКА</div>
                                <div class="product-size">BLACK Series</div>
                                <img src="img/lure.png" alt="Прикормка">
                                <h3 class="product-name">Прикормка DUNAEV BLACK</h3>

                                <div class="product-sizes">
                                    <span class="size-option">0.41мм</span>
                                    <span class="size-option">0.33мм</span>
                                    <span class="size-option">0.30мм</span>
                                    <span class="size-option">0.28мм</span>
                                </div>

                                <div class="product-stock in-stock">Есть в наличии</div>
                                <div class="product-price">268P</div>

                                <button class="add-to-cart-btn">В корзину</button>
                            </div>
                            <div class="product-card">
                                <div class="product-badge">ПРЕМИУМ</div>
                                <div class="product-size">Серия 107</div>
                                <img src="img/hooks.png" alt="Крючок">
                                <h3 class="product-name">Премиум крючок Дунаев </h3>

                                <div class="product-sizes">
                                    <span class="size-option">0.41мм</span>
                                    <span class="size-option">0.33мм</span>
                                    <span class="size-option">0.30мм</span>
                                    <span class="size-option">0.28мм</span>
                                </div>

                                <div class="product-stock out-of-stock">Нет в наличии</div>
                                <div class="product-price">145P</div>

                                <button class="add-to-cart-btn" disabled>Нет в наличии</button>
                            </div>
                            <!-- Товар 1 -->
                            <div class="product-card">
                                <div class="product-badge">ЗАВОДНОЕ</div>
                                <div class="product-size">SIZE #7</div>
                                <img src="img/spoon.png" alt="Кольцо">
                                <h3 class="product-name">Кольцо заводное Dunaev size #7</h3>

                                <div class="product-sizes">
                                    <span class="size-option">3.5мм</span>
                                    <span class="size-option">4мм</span>
                                    <span class="size-option">5мм</span>
                                    <span class="size-option">6мм</span>
                                    <span class="size-option">7мм</span>
                                </div>

                                <div class="product-stock in-stock">Есть в наличии</div>
                                <div class="product-price">100P</div>

                                <button class="add-to-cart-btn">В корзину</button>
                            </div>
                        </div>
                        <!-- Каталог товаров 3 ряд-->
                        <div class="container">
                            <div class="products-grid">
                                <!-- Товар 1 -->
                                <div class="product-card">
                                    <div class="product-badge">ЗАВОДНОЕ</div>
                                    <div class="product-size">SIZE #7</div>
                                    <img src="img/spoon.png" alt="Кольцо">
                                    <h3 class="product-name">Кольцо заводное Dunaev size #7</h3>

                                    <div class="product-sizes">
                                        <span class="size-option">3.5мм</span>
                                        <span class="size-option">4мм</span>
                                        <span class="size-option">5мм</span>
                                        <span class="size-option">6мм</span>
                                        <span class="size-option">7мм</span>
                                    </div>

                                    <div class="product-stock in-stock">Есть в наличии</div>
                                    <div class="product-price">100P</div>

                                    <button class="add-to-cart-btn">В корзину</button>
                                </div>

                                <!-- Товар 2 -->
                                <div class="product-card">
                                    <div class="product-badge">ШНУР</div>
                                    <div class="product-size">PE X4 150 м.</div>
                                    <img src="img/Cord.png" alt="Шнур">
                                    <h3 class="product-name">Шнур Дунаев Braid PE X4 150 м.</h3>

                                    <div class="product-sizes">
                                        <span class="size-option">0.38мм</span>
                                        <span class="size-option">0.20мм</span>
                                        <span class="size-option">0.12мм</span>
                                        <span class="size-option">0.08мм</span>
                                    </div>

                                    <div class="product-stock low-stock">Осталось 2шт</div>
                                    <div class="product-price">600P</div>

                                    <button class="add-to-cart-btn">В корзину</button>
                                </div>

                                <!-- Товар 3 -->
                                <div class="product-card">
                                    <div class="product-badge">ПРЕМИУМ</div>
                                    <div class="product-size">Серия 107</div>
                                    <img src="img/hooks.png" alt="Крючок">
                                    <h3 class="product-name">Премиум крючок Дунаев </h3>

                                    <div class="product-sizes">
                                        <span class="size-option">0.41мм</span>
                                        <span class="size-option">0.33мм</span>
                                        <span class="size-option">0.30мм</span>
                                        <span class="size-option">0.28мм</span>
                                    </div>

                                    <div class="product-stock out-of-stock">Нет в наличии</div>
                                    <div class="product-price">145P</div>

                                    <button class="add-to-cart-btn" disabled>Нет в наличии</button>
                                </div>

                                <!-- Товар 4 -->
                                <div class="product-card">
                                    <div class="product-badge">ПРИКОРМКА</div>
                                    <div class="product-size">BLACK Series</div>
                                    <img src="img/lure.png" alt="Прикормка">
                                    <h3 class="product-name">Прикормка DUNAEV BLACK </h3>

                                    <div class="product-sizes">
                                        <span class="size-option">0.41мм</span>
                                        <span class="size-option">0.33мм</span>
                                        <span class="size-option">0.30мм</span>
                                        <span class="size-option">0.28мм</span>
                                    </div>

                                    <div class="product-stock in-stock">Есть в наличии</div>
                                    <div class="product-price">268P</div>

                                    <button class="add-to-cart-btn">В корзину</button>
                                </div>
                                <div class="product-card">
                                    <div class="product-badge">ЗАВОДНОЕ</div>
                                    <div class="product-size">SIZE #7</div>
                                    <img src="img/spoon.png" alt="Кольцо">
                                    <h3 class="product-name">Кольцо заводное Dunaev size #7</h3>

                                    <div class="product-sizes">
                                        <span class="size-option">3.5мм</span>
                                        <span class="size-option">4мм</span>
                                        <span class="size-option">5мм</span>
                                        <span class="size-option">6мм</span>
                                        <span class="size-option">7мм</span>
                                    </div>

                                    <div class="product-stock in-stock">Есть в наличии</div>
                                    <div class="product-price">100P</div>

                                    <button class="add-to-cart-btn">В корзину</button>
                                </div>
                                <div class="product-card">
                                    <div class="product-badge">ШНУР</div>
                                    <div class="product-size">PE X4 150 м.</div>
                                    <img src="img/Cord.png" alt="Шнур">
                                    <h3 class="product-name">Шнур Дунаев Braid PE X4 150 м.</h3>

                                    <div class="product-sizes">
                                        <span class="size-option">0.38мм</span>
                                        <span class="size-option">0.20мм</span>
                                        <span class="size-option">0.12мм</span>
                                        <span class="size-option">0.08мм</span>
                                    </div>

                                    <div class="product-stock low-stock">Осталось 2шт</div>
                                    <div class="product-price">600P</div>

                                    <button class="add-to-cart-btn">В корзину</button>
                                </div>
                            </div>
                            <!-- Каталог товаров 3 ряд-->
                            <div class="container">
                                <div class="products-grid">
                                    <!-- Товар 1 -->
                                    <div class="product-card">
                                        <div class="product-badge">ЗАВОДНОЕ</div>
                                        <div class="product-size">SIZE #7</div>
                                        <img src="img/spoon.png" alt="Кольцо">
                                        <h3 class="product-name">Кольцо заводное Dunaev size #7</h3>

                                        <div class="product-sizes">
                                            <span class="size-option">3.5мм</span>
                                            <span class="size-option">4мм</span>
                                            <span class="size-option">5мм</span>
                                            <span class="size-option">6мм</span>
                                            <span class="size-option">7мм</span>
                                        </div>

                                        <div class="product-stock in-stock">Есть в наличии</div>
                                        <div class="product-price">100P</div>

                                        <button class="add-to-cart-btn">В корзину</button>
                                    </div>

                                    <!-- Товар 2 -->
                                    <div class="product-card">
                                        <div class="product-badge">ШНУР</div>
                                        <div class="product-size">PE X4 150 м.</div>
                                        <img src="img/Cord.png" alt="Шнур">
                                        <h3 class="product-name">Шнур Дунаев Braid PE X4 150 м.</h3>

                                        <div class="product-sizes">
                                            <span class="size-option">0.38мм</span>
                                            <span class="size-option">0.20мм</span>
                                            <span class="size-option">0.12мм</span>
                                            <span class="size-option">0.08мм</span>
                                        </div>

                                        <div class="product-stock low-stock">Осталось 2шт</div>
                                        <div class="product-price">600P</div>

                                        <button class="add-to-cart-btn">В корзину</button>
                                    </div>

                                    <!-- Товар 3 -->
                                    <div class="product-card">
                                        <div class="product-badge">ПРЕМИУМ</div>
                                        <div class="product-size">Серия 107</div>
                                        <img src="img/hooks.png" alt="Крючок">
                                        <h3 class="product-name">Премиум крючок Дунаев</h3>

                                        <div class="product-sizes">
                                            <span class="size-option">0.41мм</span>
                                            <span class="size-option">0.33мм</span>
                                            <span class="size-option">0.30мм</span>
                                            <span class="size-option">0.28мм</span>
                                        </div>

                                        <div class="product-stock out-of-stock">Нет в наличии</div>
                                        <div class="product-price">145P</div>

                                        <button class="add-to-cart-btn" disabled>Нет в наличии</button>
                                    </div>

                                    <!-- Товар 4 -->
                                    <div class="product-card">
                                        <div class="product-badge">ПРИКОРМКА</div>
                                        <div class="product-size">BLACK Series</div>
                                        <img src="img/lure.png" alt="Прикормка">
                                        <h3 class="product-name">Прикормка DUNAEV BLACK </h3>

                                        <div class="product-sizes">
                                            <span class="size-option">0.41мм</span>
                                            <span class="size-option">0.33мм</span>
                                            <span class="size-option">0.30мм</span>
                                            <span class="size-option">0.28мм</span>
                                        </div>

                                        <div class="product-stock in-stock">Есть в наличии</div>
                                        <div class="product-price">268P</div>

                                        <button class="add-to-cart-btn">В корзину</button>
                                    </div>
                                    <div class="product-card">
                                        <div class="product-badge">ШНУР</div>
                                        <div class="product-size">PE X4 150 м.</div>
                                        <img src="img/Cord.png" alt="Шнур">
                                        <h3 class="product-name">Шнур Дунаев Braid PE X4 150 м.</h3>

                                        <div class="product-sizes">
                                            <span class="size-option">0.38мм</span>
                                            <span class="size-option">0.20мм</span>
                                            <span class="size-option">0.12мм</span>
                                            <span class="size-option">0.08мм</span>
                                        </div>

                                        <div class="product-stock low-stock">Осталось 2шт</div>
                                        <div class="product-price">600P</div>

                                        <button class="add-to-cart-btn">В корзину</button>
                                    </div>
                                </div>

                                <!-- Пагинация -->
                    <div class="pagination">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>
