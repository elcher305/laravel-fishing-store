<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная </title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
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
        <img src="{{ asset('img/Phone-Rounded.svg') }}" alt="logo">
        <div class="user_menu">
            <a><b>+7(924) 613-43-45</b></a>
            <a href="{{ route('login') }}">Личный кабинет</a>
        </div>
    </nav>

    <div class="main-menu">
        <span id="logo">
            <img src="img/logo_site.svg" alt="">
        </span>
        <form class="search-field">
            <a class="button-catalog" >Каталог</a>
            <input type="text" placeholder="Поиск товара..." >
            <button type="submit"><img src="img/Magnifer.svg" alt=""></button>

            <a class="icons-menu">
                <img src="img/Heart-blue.svg" alt="">

                <a href="{{ route('cart.index')}}"><img src="img/fi-rr-shopping-bag.svg" alt="Корзина"></a>
            </a>
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
        <a><b>Зимняя рыбалка </b></a>
        <a><b>Кормушки</b></a>
        <a><b>Летняя рыбалка</b></a>
        <a><b> Одежда</b></a>
    </nav>

</header>

<!-- Главное содержимое -->
<main>
    <section class="banner">
        <img src="img/foto_banner.png" alt="">
    </section>

    <!-- Блок преимуществ компаний -->
    <section class="company-advantages">
        <div class="container">
            <div class="advantages-grid">
                <!-- Преимущество 1 -->
                <div class="advantage-box">
                    <div class="advantage-icon"><img src="img/3d-rotate.svg" alt="Возврат товара" ></div>
                    <div class="advantage-content">
                        <h3 class="advantage-title">Возврат товара</h3>
                        <p class="advantage-description">Возврат товара в течение 30 дней</p>
                    </div>
                </div>

                <!-- Преимущество 2 -->
                <div class="advantage-box">
                    <div class="advantage-icon"><img src="img/icon-delivery.svg" alt="Доставка" ></div>
                    <div class="advantage-content">
                        <h3 class="advantage-title">Удобная доставка по России</h3>
                        <p class="advantage-description">Быстрая и надежная доставка</p>
                    </div>
                </div>

                <!-- Преимущество 3 -->
                <div class="advantage-box">
                    <div class="advantage-icon"><img src="img/card.svg" alt="Карта оплаты" ></div>
                    <div class="advantage-content">
                        <h3 class="advantage-title">Выбор оплаты</h3>
                        <p class="advantage-description">Оплата онлайн или при получении</p>
                    </div>
                </div>

                <!-- Преимущество 4 -->
                <div class="advantage-box">
                    <div class="advantage-icon"><img src="img/shield-tick.svg" alt="Качество товара" ></div>
                    <div class="advantage-content">
                        <h3 class="advantage-title">Проверенные бренды</h3>
                        <p class="advantage-description">Только качественные товары</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Категории -->
    <section class="categories">
        <div class="category_section">
            <p id="header-clothes"><b>Одежда</b></p>
            <img src="img/clothing-section.png" alt="">
        </div>

        <div class="fishing-line">
            <p id="fishing_line_header"><b>Леска</b></p>
            <img src="img/fishing-line.png" alt="Леска для рыбалки">
        </div>

        <div class="category_rods">
            <p id="fishing_rod_header"><b>Удилища</b></p>
            <img src="img/Rods.png" alt="Удилища">
        </div>
    </section>

    <section class="categories_two">
        <div class="category_baits">
            <p id="bait-header"><b>Приманки</b></p>
            <img src="img/baits.png" alt="Приманки">
        </div>

        <div class="category_accessories">
            <p id="header_accessories"><b>Аксессуары</b></p>
            <img src="img/accessories.png" alt="Акссесуары">
        </div>

        <div class="category_coil">
            <p id="header_reel"><b>Катушки</b></p>
            <img src="img/The-coil.png" alt="Катушки">
        </div>
    </section>

    <!-- Блок лучших товаров -->
    <section class="best-products">
        <div class="container">
            <h1 class="best-products-title">Лучшие товары</h1>

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
                    <h3 class="product-name">Премиум крючок Дунаев Серия 107</h3>

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
                    <h3 class="product-name">Прикормка DUNAEV BLACK Series</h3>

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
            </div>

    </section>

    <!-- Акции и спецпредложения -->
    <section class="promotions">
        <div class="container">
            <h1 class="section-title">Акции и спецпредложения</h1>
            <div class="promotions__grid">
                <div class="promotion-card">
                    <div class="promotion-card__content">
                        <h3 class="promotion-card__title">Уценка</h3>
                        <p class="promotion-card__description">Специальные цены на товары с небольшими дефектами</p>
                        <a href="#" class="promotion-card__link">Подробнее »</a>
                    </div>
                </div>
                <div class="promotion-card">
                    <div class="promotion-card__content">
                        <h3 class="promotion-card__title">Крутые скидки</h3>
                        <p class="promotion-card__description">Скидки до 50% на товары определенной категории</p>
                        <a href="#" class="promotion-card__link">Подробнее »</a>
                    </div>
                </div>
                <div class="promotion-card">
                    <div class="promotion-card__content">
                        <h3 class="promotion-card__title">Товары дня</h3>
                        <p class="promotion-card__description">Ежедневные специальные предложения</p>
                        <a href="#" class="promotion-card__link">Подробнее »</a>
                    </div>
                </div>
                <div class="promotion-card promotion-card--all">
                    <div class="promotion-card__content">
                        <h3 class="promotion-card__title">Все акции</h3>
                        <p class="promotion-card__description">Посмотреть все текущие акции и спецпредложения</p>
                        <a href="#" class="promotion-card__link">Подробнее »</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок брендов -->
    <section class="brands-section-images">
        <div class="container">
            <div class="brands-header">
                <h2 class="brands-title">Бренды</h2>
                <a href="#" class="view-all-link">Посмотреть все →</a>
            </div>

            <div class="brands-grid-images">
                <div class="brand-item">
                    <div class="brand-image">
                        <!-- Можно добавить img или использовать span как запасной вариант -->
                        <img src="img/dawa_logo.png" alt="">
                    </div>
                </div>
                <!-- остальные бренды... -->
                <div class="brand-item">
                    <div class="brand-image">
                        <!-- Можно добавить img или использовать span как запасной вариант -->
                        <img src="img/shimano_logo.png" alt="">
                    </div>
                </div>
                <div class="brand-item">
                    <div class="brand-image">
                        <!-- Можно добавить img или использовать span как запасной вариант -->
                        <img src="img/okuma_logo.png" alt="">
                    </div>
                </div>
                <div class="brand-item">
                    <div class="brand-image">
                        <!-- Можно добавить img или использовать span как запасной вариант -->
                        <img src="img/norfin_logo.png" alt="">
                    </div>
                </div>
                <div class="brand-item">
                    <div class="brand-image">
                        <!-- Можно добавить img или использовать span как запасной вариант -->
                        <img src="img/matrix_logo.png" alt="">
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
                    <span class="logo-icon"><img src="img/logo-grey.svg" alt=""></span>
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
                    <a href="#" class="social-btn"><img src="img/vk_icon.svg" alt=""></a>
                    <a href="#" class="social-btn"><img src="img/tg_icon.svg" alt=""></a>
                    <a href="#" class="social-btn"><img src="img/yt_icon.svg" alt=""></a>
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


