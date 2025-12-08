<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Описание товара</title>
    <link href="{{ asset('css/styleInfo-tovar.css') }}" rel="stylesheet">
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
                <img src="img/Heart-blue.svg" alt="">
                <a href="basketOfGoods.html"><img src="img/fi-rr-shopping-bag.svg" alt=""></a>
                <img src="img/Chart-blue.svg" alt="">
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

<!-- Основной контент -->
<main class="product-page">
    <div class="container">
        <!-- Хлебные крошки -->
        <div class="breadcrumbs">
            <a href="index.html">Главная</a>
            <span class="separator">–</span>
            <a href="catalog.html">Каталог</a>
            <span class="separator">–</span>
            <span>Прикормка DUNAEV BLACK Series</span>
        </div>

        <div class="product-layout">
            <!-- Левая колонка - изображение товара -->
            <div class="product-gallery">
                <div class="main-image">
                    <img src="img/lure.png" alt="Прикормка DUNAEV BLACK Series">
                </div>
            </div>

            <!-- Центральная колонка - основная информация -->
            <div class="product-info">
                <h1 class="product-title">Прикормка DUNAEV BLACK Series 1 кг BREAM</h1>

                <!-- Характеристики -->
                <div class="specifications">
                    <h2>Характеристики:</h2>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Серия товара:</span>
                            <span class="spec-value"><strong>Dunaev Black Series</strong></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Категория рыбалки:</span>
                            <span class="spec-value"><strong>Летняя рыбалка</strong></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Бренд:</span>
                            <span class="spec-value"><strong>DUNAEV</strong></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Импортер:</span>
                            <span class="spec-value"><strong>Россия</strong></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Страна производства:</span>
                            <span class="spec-value"><strong>Россия</strong></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Масса:</span>
                            <span class="spec-value"><strong>1 кг</strong></span>
                        </div>
                    </div>

                </div>
                <!-- Наличие -->
                <div class="stock-info">
                    <h2>На складе:</h2>
                    <a class="stock-status in-stock">В наличии</a>
                    <span class="price">239 P</span>
                    <button class="buy-btn">Купить ₽</button>
                </div>

            </div>
        </div>

        <!-- Описание товара -->
        <section class="product-description">
            <h2>Описание:</h2>
            <div class="description-content">
                <p><strong>Новинка 2022 года!</strong> Dunaev Black Series - серия специализированных прикормок премиального качества. Прикормки содержат новые сбалансированные составы. Dunaev Black Series сочетает в себе несколько видов смесей (Bream, Carp, Feeder, Roach, Universal), имеющих черный цвет, естественный запах ингредиентов или минимальное количество ароматизаторов. Эти прикормки могут применяться на тех водоемах, где рыбу пугают сильно выраженные ароматы и в сезон холодной воды: весной, осенью и зимой.</p>

                <p>Dunaev Black Series Bream (Черный Лец) – средне-франционная смесь полностью повторяет рецептуру популярной смеси Dunaev Черный Лец Premium. Это колрасодержащая смесь с большим количеством бисквита и мямоков масленичных культур. Имеет исключительно натуральный, приятный шоколадно-ванильный запах ингредиентов. Смесь активная по механике, умеренно липкая. Может применяться в поплавочных и фидерных рецептурах как самостоятельная прикормка, так и в смеси с другими прикормками.</p>
            </div>
        </section>

        <!-- Отзывы -->
        <section class="reviews-section">
            <h2>Отзывы</h2>

            <div class="reviews-grid">
                <!-- Отзыв 1 -->
                <div class="review-card">
                    <div class="circle">
                        <a class="name-user">User</a>
                        <a class="stars">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                        </a>
                    </div>
                    <div class="review-text">
                        Dunaev Black Series Bream (Черный Лец) – средне-франционная смесь полностью повторяет рецептуру популярной смеси Dunaev Черный Лец Premium. Это колрасодержащая смесь с большим количеством бисквита и мямоков масленичных культур. Имеет исключительно натуральный, приятный шоколадно-ванильный запах ингредиентов. Смесь активная по механике, умеренно липкая.
                    </div>
                    <a href="#" class="show-all">Показать все →</a>
                </div>

                <!-- Отзыв 2 -->
                <div class="review-card">
                    <div class="circle">
                        <a class="name-user">User</a>
                        <a class="stars">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                        </a>
                    </div>
                    <div class="review-text">
                        Dunaev Black Series Bream (Черный Лец) – средне-франционная смесь полностью повторяет рецептуру популярной смеси Dunaev Черный Лец Premium. Это колрасодержащая смесь с большим количеством бисквита и мямоков масленичных культур. Имеет исключительно натуральный, приятный шоколадно-ванильный запах ингредиентов. Смесь активная по механике, умеренно липкая.
                    </div>
                    <a href="#" class="show-all">Показать все →</a>
                </div>

                <!-- Отзыв 3 -->
                <div class="review-card">
                    <div class="circle">
                        <a class="name-user">User</a>
                        <a class="stars">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                            <img src="img/star.svg" alt="">
                        </a>
                    </div>
                    <div class="review-text">
                        Dunaev Black Series Bream (Черный Лец) – средне-франционная смесь полностью повторяет рецептуру популярной смеси Dunaev Черный Лец Premium. Это колрасодержащая смесь с большим количеством бисквита и мямоков масленичных культур. Имеет исключительно натуральный, приятный шоколадно-ванильный запах ингредиентов. Смесь активная по механике, умеренно липкая.
                    </div>
                    <a href="#" class="show-all">Показать все →</a>
                </div>
            </div>
        </section>

        <!-- Вы смотрели -->
        <section class="viewed-section">
            <h2>Вы смотрели</h2>

            <div class="viewed-products">
                <!-- Товар 1 -->
                <div class="viewed-product">
                    <img src="img/snap-in.png" alt="">
                    <h3 class="product-name">Стопорная оснастка Вертолет Dunaev</h3>
                    <div class="product-prices">
                        <span class="current-price">180 ₽</span>
                        <span class="old-price">250 ₽</span>
                        <a class="btn-shopping-cart"><img src="img/fi-rr-shopping-cart.svg" alt=""></a>
                    </div>
                </div>

                <!-- Товар 2 -->
                <div class="viewed-product">
                    <img src="img/snap-in.png" alt="">
                    <h3 class="product-name">Стопорная оснастка Вертолет Dunaev</h3>
                    <div class="product-prices">
                        <span class="current-price">180 ₽</span>
                        <span class="old-price">250 ₽</span>
                        <a class="btn-shopping-cart"><img src="img/fi-rr-shopping-cart.svg" alt=""></a>
                    </div>
                </div>

                <!-- Товар 3 -->
                <div class="viewed-product">
                    <img src="img/snap-in.png" alt="">
                    <h3 class="product-name">Стопорная оснастка Вертолет Dunaev</h3>
                    <div class="product-prices">
                        <span class="current-price">180 ₽</span>
                        <span class="old-price">250 ₽</span>
                        <a class="btn-shopping-cart"><img src="img/fi-rr-shopping-cart.svg" alt=""></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
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

    </div>
</footer>
</body>
</html>
