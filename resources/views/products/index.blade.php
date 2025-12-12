<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style-catalog.css') }}">

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
                            @foreach($brands as $brand)
                                @if($brand)
                                    <label class="checkbox-option">
                                        <input type="checkbox" name="brand[]" value="{{ $brand }}"
                                            {{ in_array($brand, (array)request('brand', [])) ? 'checked' : '' }}>
                                        <span class="checkbox-custom">✓</span>
                                        <span class="checkbox-label">{{ $brand }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Кнопки фильтрации -->
                    <div class="filter-actions">
                        <button type="submit" form="filter-form" class="filter-btn apply-btn">показать</button>
                        <a href="{{ route('products.index') }}" class="filter-btn reset-btn">сбросить</a>
                    </div>
                </aside>

                <div class="container">
                    <h1 class="best-products-title">Каталог товаров</h1>

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

                    <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="hidden">
                        <input type="hidden" name="price" id="filter-price">
                        <input type="hidden" name="category[]" id="filter-category">
                        <input type="hidden" name="brand[]" id="filter-brand">
                        <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
                        <input type="hidden" name="order" value="{{ request('order', 'desc') }}">
                    </form>

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

                                <h3 class="product-name">
                                    <a href="{{ route('products.show', $product) }}" style="color: inherit; text-decoration: none;">
                                        {{ $product->name }}
                                    </a>
                                </h3>

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
                                        ★ {{ number_format($product->average_rating, 1) }} ({{ $product->reviews_count }})
                                    </div>
                                @endif
                            </div>
                        @endforeach
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обработка фильтров
        const filterForm = document.getElementById('filter-form');
        const priceInputs = document.querySelectorAll('input[name="price"]');
        const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
        const brandCheckboxes = document.querySelectorAll('input[name="brand[]"]');
        const categoryAll = document.querySelector('input[name="category_all"]');
        const brandAll = document.querySelector('input[name="brand_all"]');

        // Обработка выбора цены
        priceInputs.forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('filter-price').value = this.value;
                filterForm.submit();
            });
        });

        // Обработка категорий
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateCategoryFilter();
            });
        });

        categoryAll.addEventListener('change', function() {
            if (this.checked) {
                categoryCheckboxes.forEach(cb => cb.checked = false);
                document.getElementById('filter-category').value = '';
                filterForm.submit();
            }
        });

        // Обработка брендов
        brandCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBrandFilter();
            });
        });

        brandAll.addEventListener('change', function() {
            if (this.checked) {
                brandCheckboxes.forEach(cb => cb.checked = false);
                document.getElementById('filter-brand').value = '';
                filterForm.submit();
            }
        });

        function updateCategoryFilter() {
            const selected = Array.from(categoryCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            document.getElementById('filter-category').value = selected.join(',');
            filterForm.submit();
        }

        function updateBrandFilter() {
            const selected = Array.from(brandCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            document.getElementById('filter-brand').value = selected.join(',');
            filterForm.submit();
        }

        // Добавление в корзину через AJAX
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Товар добавлен в корзину!');
                            // Обновляем счетчик корзины
                            updateCartCount();
                        } else {
                            alert(data.message || 'Ошибка при добавлении в корзину');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при добавлении в корзину');
                    });
            });
        });

        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const cartBadge = document.querySelector('.cart-count');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = data.count > 0 ? 'inline' : 'none';
                    }
                });
        }
    });
</script>
</body>
</html>
