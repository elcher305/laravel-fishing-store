<!-- resources/views/catalog/catalog.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link rel="stylesheet" href="{{ asset('css/style-catalog.css') }}">
    <script src="../js/catalog.js"></script>
</head>
<body>
<!-- Шапка -->
<header class="header">
    <nav class="header_menu">
        <a>Блог</a>
        <a>О нас</a>
        <a>Отзывы</a>
        <a>Доставка и оплата</a>
        <a>Политика конфиденциальности</a>
        <img src="{{ asset('img/Phone-Rounded.svg') }}" alt="">
        <div class="user_menu">
            <a><b>+7(924) 613-43-45</b></a>
            <a>Личный кабинет</a>
        </div>
    </nav>

    <div class="main-menu">
        <span id="logo">
            <img src="{{ asset('img/logo_site.svg') }}" alt="">
        </span>
        <form class="search-field">
            <a class="button-catalog">Каталог</a>
            <input type="text" placeholder="Поиск товара..." >
            <button type="submit"><img src="{{ asset('img/Magnifer.svg') }}" alt=""></button>

            <div class="icons-menu">
                <img src="{{ asset('img/Heart-blue.svg') }}" alt="">
                <a href="{{ route('cart.index') }}" >
                    <img src="{{ asset('img/fi-rr-shopping-bag.svg') }}" alt="">
                </a>
                <img src="{{ asset('img/Chart-blue.svg') }}" alt="">
            </div>
        </form>

    </div>

    <nav class="basic-menu">
        <a><b>Бренды</b></a>
        <a><b>Приманки</b></a>
        <a><b>Спиннинг</b></a>
        <a><b>Крючки</b></a>
        <a><b>Фидер</b></a>
        <a><b>Аксессуары</b></a>
        <a><b>Другое</b></a>
        <a><b>Поплавок</b></a>
        <a><b>Зимняя рыбалка</b></a>
        <a><b>Кормушки</b></a>
        <a><b>Летняя рыбалка</b></a>
        <a><b>Одежда</b></a>
    </nav>

</header>

<main>
    <!-- Блок фильтрации товаров -->
    <section class="products-filter">
        <div class="container">
            <!-- Хлебные крошки -->
            <div class="breadcrumbs">
                <a href="/" class="breadcrumb-link">Главная</a>
                <span class="breadcrumb-separator">–</span>
                <span class="breadcrumb-current">Летняя рыбалка</span>
            </div>

            <div class="filter-container">

                <aside class="filter-sidebar">
                    <h2 class="filter-title">Фильтры</h2>


                    <div class="filter-group">
                        <h3 class="filter-group-title">Цена</h3>
                        <div class="price-options">
                            <label class="radio-option">
                                <input type="radio" name="price" value="low">
                                <span class="radio-custom"></span>
                                <span class="radio-label">До 1000 руб</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="price" value="medium">
                                <span class="radio-custom"></span>
                                <span class="radio-label">1000 - 3000 руб</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="price" value="high">
                                <span class="radio-custom"></span>
                                <span class="radio-label">От 3000 руб</span>
                            </label>
                        </div>
                    </div>


                    <div class="filter-group">
                        <h3 class="filter-group-title">Тип</h3>
                        <div class="checkbox-options">
                            <label class="checkbox-option">
                                <input type="checkbox" name="type">
                                <span class="checkbox-custom">✓</span>
                                <span class="checkbox-label">Все типы</span>
                            </label>
                        </div>
                    </div>


                    <div class="filter-group">
                        <h3 class="filter-group-title">Бренд</h3>
                        <div class="checkbox-options">
                            <label class="checkbox-option">
                                <input type="checkbox" name="brand">
                                <span class="checkbox-custom">✓</span>
                                <span class="checkbox-label">Все бренды</span>
                            </label>
                        </div>
                    </div>


                    <div class="filter-actions">
                        <button class="filter-btn apply-btn">показать</button>
                        <button class="filter-btn reset-btn">сбросить</button>
                    </div>
                </aside>

                <div class="container">
                    <h1 class="best-products-title">Товары для летней рыбалки</h1>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                @if($product->badge)
                                    <div class="product-badge">{{ $product->badge }}</div>
                                @endif

                                @if($product->sizes && count(json_decode($product->sizes)) > 0)
                                    <div class="product-size">
                                        {{ json_decode($product->sizes)[0] }}
                                    </div>
                                @endif

                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/spoon.png') }}" alt="{{ $product->name }}">
                                @endif

                                <h3 class="product-name">{{ $product->name }}</h3>

                                @if($product->sizes)
                                    <div class="product-sizes">
                                        @foreach(json_decode($product->sizes) as $size)
                                            <span class="size-option" data-size="{{ $size }}">
                                                {{ $size }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="product-stock
                                    @if($product->stock > 5) in-stock
                                    @elseif($product->stock > 0) low-stock
                                    @else out-of-stock @endif">
                                    @if($product->stock > 5)
                                        Есть в наличии
                                    @elseif($product->stock > 0)
                                        Осталось {{ $product->stock }}шт
                                    @else
                                        Нет в наличии
                                    @endif
                                </div>

                                <div class="product-price">{{ $product->price }}P</div>

                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    @if($product->sizes)
                                        <input type="hidden" name="size" id="selected-size-{{ $product->id }}">
                                    @endif

                                    <button type="submit" class="add-to-cart-btn"
                                            @if($product->stock == 0) disabled @endif>
                                        @if($product->stock > 0)
                                            В корзину
                                        @else
                                            Нет в наличии
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Подвал сайта -->
<footer class="footer-columns">
    <div class="container_footer">
        <div class="footer-grid">
            <!-- Колонка 1 - Бренд -->
            <div class="footer-col">
                <div class="footer-logo">
                    <span class="logo-icon"><img src="{{ asset('img/logo-grey.svg') }}" alt=""></span>
                </div>
                <p class="brand-tagline">Снасти для профессионалов</p>
            </div>

            <!-- Колонка 2 - Контакты -->
            <div class="footer-col">
                <h4>Контакты</h4>
                <div class="contact-list">
                    <div class="contact-line">
                        <strong>О нас:</strong>
                    </div>
                    <div class="contact-line">
                        <strong>Адрес:</strong> Томск, ул.Ленина, 237 стр.м 3
                    </div>
                    <div class="contact-line">
                        <strong>Телефон:</strong> +7(924) 613-43-45
                    </div>
                    <div class="contact-line">
                        <strong>Email:</strong> <b>support@catfish70.ru</b>
                    </div>
                </div>
            </div>

            <!-- Колонка 3 - Быстрые ссылки -->
            <div class="footer-col">
                <h4>Меню</h4>
                <ul class="footer-links">
                    <li><a href="#">Каталог</a></li>
                    <li><a href="#">Акции</a></li>
                    <li><a href="#">Доставка</a></li>
                    <li><a href="#">О нас</a></li>
                </ul>
            </div>

            <!-- Колонка 4 - Соцсети -->
            <div class="footer-col">
                <h4>Мы в соцсетях</h4>
                <div class="social-buttons">
                    <a href="#" class="social-btn"><img src="{{ asset('img/vk_icon.svg') }}" alt=""></a>
                    <a href="#" class="social-btn"><img src="{{ asset('img/tg_icon.svg') }}" alt=""></a>
                    <a href="#" class="social-btn"><img src="{{ asset('img/yt_icon.svg') }}" alt=""></a>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <p>Копирование изображений с нашего сайта запрещено и охраняется законом об авторском праве.</p>
            <p>Информация, представленная на сайте, не является публичной офертой.</p>
        </div>
    </div>
</footer>


</body>
</html>
