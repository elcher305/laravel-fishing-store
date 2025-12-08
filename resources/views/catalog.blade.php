<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link href="{{ asset('css/style-catalog.css') }}" rel="stylesheet">
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
        <img src="img/Phone-Rounded.svg" alt="">
        <div class="user_menu">
            <a><b>+7(924) 613-43-45</b></a>
            <a>Личный кабинет</a>
        </div>
    </nav>

    <div class="main-menu">
        <span id="logo">
            <img src="img/logo_site.svg" alt="">
        </span>
        <form class="search-field">
            <a class="button-catalog">Каталог</a>
            <input type="text" placeholder="Поиск товара..." >
            <button type="submit"><img src="img/Magnifer.svg" alt=""></button>

            <div class="icons-menu">
                <img src="img/Heart-blue.svg" alt="Избранное">
                <a> <img src="img/fi-rr-shopping-bag.svg" alt="Корзина">

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
                <a href="#" class="breadcrumb-link">Главная</a>
                <span class="breadcrumb-separator">–</span>
                <span class="breadcrumb-current">Летняя рыбалка</span>
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

                    <!-- Фильтр по типу -->
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

                    <!-- Фильтр по бренду -->
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

                    <!-- Кнопки фильтрации -->
                    <div class="filter-actions">
                        <button class="filter-btn apply-btn">показать</button>
                        <button class="filter-btn reset-btn">сбросить</button>
                    </div>
                </aside>

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
