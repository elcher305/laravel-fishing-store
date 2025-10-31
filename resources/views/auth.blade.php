<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>All Fine</title>
    <link rel="stylesheet" href="{{ asset('css/login_register_style.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.ico') }}">
    <style>
        .error-message {
            color: #ff4444;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            color: #00C851;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <div class="head">
        <a class="logo" href="{{ route('home') }}"><img src="{{ asset('img/logo.svg') }}" alt="logo"></a>
        <nav>
            <a href="{{ route('works') }}">Работы</a>
            <a href="{{ route('masters') }}">Мастера</a>
            <a href="{{ route('contacts') }}">Контакты</a>
            <a href="{{ route('sign_up') }}">Запись</a>
            @auth
                <a href="{{ route('profile') }}">Профиль</a>
            @else
                <a href="{{ route('auth.form') }}" style="text-decoration: underline;">Войти</a>
            @endauth
        </nav>
    </div>
</header>
<main>
    <p>[регистрация/вход]</p>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-message" style="text-align: center; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="sign">
        <!-- Регистрация -->
        <div class="online" @if(session('active_tab') == 'login') style="display:none;" @endif id="registerForm">
            <p>Зарегистрироваться</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label for="email">Электронная почта</label>
                <input type="email" id="email" name="email" required placeholder="yourmail@mail.com" value="{{ old('email') }}">
                @error('email', 'register')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="username">Имя</label>
                <input type="text" id="username" name="username" required placeholder="Сонечка" value="{{ old('username') }}">
                @error('username', 'register')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                @error('password', 'register')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password_confirmation">Повторите пароль</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <button type="submit">Регистрация</button>
            </form>
            <p style="text-align: center; margin-top: 15px;">
                Уже есть аккаунт?
                <a href="#" onclick="showLogin()" style="color: #007bff; cursor: pointer;">Войти</a>
            </p>
        </div>

        <!-- Вход -->
        <div class="free" @if(session('active_tab') != 'login') style="display:none;" @endif id="loginForm">
            <p>Войти</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email_login">Электронная почта</label>
                <input type="email" id="email_login" name="email_login" required placeholder="yourmail@mail.com" value="{{ old('email_login') }}">
                @error('email_login', 'login')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password_login">Пароль</label>
                <input type="password" id="password_login" name="password_login" required>
                @error('password_login', 'login')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit">Вход</button>
            </form>
            <p style="text-align: center; margin-top: 15px;">
                Нет аккаунта?
                <a href="#" onclick="showRegister()" style="color: #007bff; cursor: pointer;">Зарегистрироваться</a>
            </p>
        </div>
    </div>
</main>
<footer>
    <div class="cont">
        <div class="time">
            <p class="bigger">Прийти</p>
            <p>Часы работы</p>
            <p>с 10:00 до 22:00, ежедневно</p>
            <p class="up">Адрес:</p>
            <p>Томск, Ленина 18/3</p>
        </div>
        <div class="write">
            <p class="bigger">Написать</p>
            <nav>
                <a href="#"><img src="{{ asset('img/telegram.svg') }}" alt="tg"></a>
                <a href="#"><img src="{{ asset('img/vk.svg') }}" alt="vk"></a>
                <a href="#"><img src="{{ asset('img/instagram.svg') }}" alt="inst"></a>
                <a href="#"><img src="{{ asset('img/pinterest-64.svg') }}" alt="pin"></a>
            </nav>
            <p class="up">all.fine@tattoo.ru</p>
        </div>
        <div class="call">
            <p class="bigger">Позвонить</p>
            <p>Телефон:</p>
            <p>+7-999-888-35-35</p>
        </div>
    </div>
</footer>

<script>
    function showLogin() {
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block';
    }

    function showRegister() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
    }

    // Показываем нужную форму при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('active_tab') == 'login')
        showLogin();
        @else
        showRegister();
        @endif
    });
</script>
</body>
</html>
