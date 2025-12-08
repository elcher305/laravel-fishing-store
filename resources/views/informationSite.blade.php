<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Сибирская рыбалка</title>
    <link href="{{ asset('css/styleInfo.css') }}" rel="stylesheet">

</head>
<body>
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
                <img src="img/fi-rr-shopping-bag.svg" alt="">
                <img src="img/Chart-blue.svg" alt="">
            </div>
        </form>

    </div>

</header>

<!-- Основной контент -->
<main class="main-content">
    <div class="container">
        <h1 class="page-title">О нашем магазине</h1>

        <!-- Секция о компании -->
        <section class="about-section">
            <h2 class="section-title">Наша история</h2>
            <p class="about-text">
                Магазин рыболовных снастей <span class="highlight">«Сибирская рыбалка»</span> был основан в 2010 году группой энтузиастов,
                для которых рыбалка – это не просто хобби, а образ жизни. Начиная с небольшого павильона на рынке,
                мы выросли в один из крупнейших специализированных магазинов в Сибирском регионе.
            </p>
            <p class="about-text">
                Наша миссия — обеспечить каждого рыбака, от новичка до профессионала, качественными снастями,
                которые помогут не только получить улов, но и насладиться процессом рыбалки в полной мере.
                Мы понимаем, что хорошая снасть — это залог успешной рыбалки и отличного настроения.
            </p>
            <p class="about-text">
                Сегодня <span class="highlight">«Сибирская рыбалка»</span> — это не просто магазин, а сообщество единомышленников,
                где опытные рыболовы делятся секретами, а новички получают квалифицированную помощь в выборе снаряжения.
            </p>
        </section>

        <!-- Секция с преимуществами -->
        <section class="advantages-section">
            <h2 class="section-title"><i class="fas fa-trophy"></i> Почему выбирают нас</h2>
            <div class="advantages-grid">
                <div class="advantage-card">
                    <i class="fas fa-check-circle advantage-icon"></i>
                    <h3 class="advantage-title">Качество и надежность</h3>
                    <p class="advantage-text">Мы работаем только с проверенными поставщиками и предлагаем снасти, которые прослужат вам долгие годы.</p>
                </div>

                <div class="advantage-card">
                    <i class="fas fa-users advantage-icon"></i>
                    <h3 class="advantage-title">Экспертные консультации</h3>
                    <p class="advantage-text">Наши консультанты — опытные рыбаки, которые помогут подобрать снасти именно для ваших условий ловли.</p>
                </div>

                <div class="advantage-card">
                    <i class="fas fa-shipping-fast advantage-icon"></i>
                    <h3 class="advantage-title">Быстрая доставка</h3>
                    <p class="advantage-text">Доставляем заказы по всей России. В городах Томск, Новосибирск и Кемерово — бесплатная доставка от 3000₽.</p>
                </div>

                <div class="advantage-card">
                    <i class="fas fa-award advantage-icon"></i>
                    <h3 class="advantage-title">Гарантия на все товары</h3>
                    <p class="advantage-text">Предоставляем официальную гарантию на все товары от 1 года. Возврат и обмен в течение 14 дней.</p>
                </div>

                <div class="advantage-card">
                    <i class="fas fa-fish advantage-icon"></i>
                    <h3 class="advantage-title">Широкий ассортимент</h3>
                    <p class="advantage-text">Более 5000 товаров для рыбалки: удилища, катушки, приманки, экипировка и специализированное снаряжение.</p>
                </div>

                <div class="advantage-card">
                    <i class="fas fa-handshake advantage-icon"></i>
                    <h3 class="advantage-title">Честные цены</h3>
                    <p class="advantage-text">Прямые поставки от производителей позволяют нам предлагать качественные товары по конкурентным ценам.</p>
                </div>
            </div>
        </section>



        <!-- Контактная информация -->
        <section class="contact-info-section">
            <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Как нас найти</h2>
            <div class="contact-grid">
                <div class="contact-item">
                    <i class="fas fa-store contact-icon"></i>
                    <div class="contact-details">
                        <h4>Наш магазин</h4>
                        <p>г. Томск, ул. Рыбацкая, д. 15<br>Торговый комплекс "Рыболов", 2 этаж</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-clock contact-icon"></i>
                    <div class="contact-details">
                        <h4>Режим работы</h4>
                        <p>Пн-Пт: 10:00 - 20:00<br>Сб-Вс: 9:00 - 18:00<br>Без перерыва</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-phone contact-icon"></i>
                    <div class="contact-details">
                        <h4>Телефоны</h4>
                        <p>+7 (3822) 55-12-34<br>+7 (913) 876-54-32 (WhatsApp, Telegram)</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-envelope contact-icon"></i>
                    <div class="contact-details">
                        <h4>Электронная почта</h4>
                        <p>info@sibir-fishing.ru<br>orders@sibir-fishing.ru (для заказов)</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>


</body>
</html>
