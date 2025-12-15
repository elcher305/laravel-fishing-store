<!-- resources/views/cart/index.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="{{ asset('css/style-basket.css')}}">
</head>
<body>
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

<div class="container">
    <div class="header">
        Корзина
    </div>

    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <h3>Ваша корзина пуста</h3>
            <p>Добавьте товары из каталога, чтобы продолжить покупки</p>
            <a href="{{ route('catalog.index') }}" class="back-to-shop">Вернуться к покупкам</a>
        </div>
    @else
        @foreach($cartItems as $item)
            <div class="cart-item">
                <div class="item-details">
                    <div class="item-info-with-image">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="item-image">
                        @else

                        @endif

                        <div class="item-info">
                            <div class="item-title">{{ $item->product->name }}</div>

                            @if($item->selected_size)
                                <div class="item-size">Размер: {{ $item->selected_size }}</div>
                            @endif

                            <div class="item-price">{{ $item->product->price * $item->quantity }} руб.</div>
                            <div class="item-subtitle">{{ $item->product->price }} руб. × {{ $item->quantity }} шт.</div>
                        </div>
                    </div>

                    <div class="quantity-control">
                        <form action="{{ route('cart.update', $item) }}" method="POST"
                              style="display: flex; align-items: center;">
                            @csrf
                            @method('PUT')

                            <button type="button" class="quantity-btn minus"
                                    onclick="this.parentNode.querySelector('input').stepDown(); this.parentNode.submit();">-</button>

                            <input type="number"
                                   name="quantity"
                                   value="{{ $item->quantity }}"
                                   min="1"
                                   max="{{ $item->product->stock }}"
                                   class="quantity-input"
                                   onchange="this.parentNode.submit()">

                            <button type="button" class="quantity-btn plus"
                                    onclick="this.parentNode.querySelector('input').stepUp(); this.parentNode.submit();">+</button>
                        </form>
                    </div>

                    <form action="{{ route('cart.destroy', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
            <div class="divider"></div>
        @endforeach

        <div class="summary">
            <div class="total">
                <div class="total-label">Итого к оплате</div>
                <div class="total-price">{{ $total }} руб.</div>
            </div>

            <div class="conditions">
                <strong>Условия заказа:</strong><br>
                • Минимальная сумма заказа: 500 руб.<br>
                • Доставка осуществляется в течение 1-3 рабочих дней<br>
                • Возврат товара возможен в течение 30 дней<br>
                • Оплата при получении или онлайн
            </div>

            <div class="cart-actions">
                @auth
                    <button id="btn-summary-pay" class="checkout-btn"
                            onclick="window.location.href='{{ route('orders.checkout') }}'">
                        Подтвердить
                    </button>
                @else
                    <div >
                        <p>
                            Для оформления заказа необходимо войти в систему
                        </p>
                        <button class="checkout-btn"
                                onclick="window.location.href='{{ route('login') }}'">
                            Войти и оформить заказ
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    @endif

    <div class="footer-note">
        © 2024 Магазин рыболовных товаров. Все права защищены.
    </div>
</div>

</body>
</html>
