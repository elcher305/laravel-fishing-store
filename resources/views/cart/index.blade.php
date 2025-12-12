<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина товаров - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style-basket.css') }}">
</head>
<body>


@if(session('success'))
    <div class="container">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container">
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    </div>
@endif

@if($cartItems->isEmpty())
    <div class="container">
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h2>Ваша корзина пуста</h2>
            <p>Добавьте товары из каталога, чтобы сделать заказ</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Перейти в каталог</a>
        </div>
    </div>
@else
    <div class="container">
        <div class="header">
            <b class="fas fa-shopping-cart">Корзина</b>
        </div>

        @foreach($cartItems as $item)
            <div class="cart-item" data-item-id="{{ $item->id }}">
                <div class="item-info">
                    <div class="item-title">{{ $item->product->name }}</div>
                    <div class="item-subtitle">{{ $item->product->brand ?: 'Без бренда' }}</div>
                    <div class="item-details">
                        <div class="item-price">{{ number_format($item->product->price, 0, ',', ' ') }} ₽</div>
                        <div class="quantity-control">
                            <button class="quantity-btn minus-btn" data-action="decrease">
                                <img src="{{ asset('img/fi-rr-minus.svg') }}" alt="Уменьшить">
                            </button>
                            <input type="text" class="quantity-input" value="{{ $item->quantity }}" readonly>
                            <button class="quantity-btn plus-btn" data-action="increase">
                                <img src="{{ asset('img/fi-rr-plus.svg') }}" alt="Увеличить">
                            </button>
                        </div>
                        <div class="item-total" style="margin-left: 20px; font-weight: bold;">
                            {{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} ₽
                        </div>
                    </div>
                </div>
                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">
                        <b class="fas fa-trash-alt">Удалить</b>
                    </button>
                </form>
            </div>
        @endforeach

        <div class="divider"></div>

        <div class="summary">
            <div class="total">
                <span class="total-label">Стоимость товаров</span>
                <span class="total-price">{{ number_format($total, 0, ',', ' ') }} ₽</span>
            </div>

            <a href="{{ route('orders.checkout') }}" id="btn-summary-pay" class="btn btn-primary">Оформить заказ</a>

            <div class="cart-actions">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Продолжить покупки</a>
                <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Очистить всю корзину?')">Очистить корзину</button>
                </form>
            </div>

            <div class="conditions">
                Оформляя заказ, вы подтверждаете свое совершеннолетие и соглашаетесь с нашими условиями обработки персональных данных.
            </div>
        </div>
    </div>

    <div class="footer-note">
        <p>Все цены указаны в рублях. Товары в корзине сохраняются 30 дней.</p>
    </div>
@endif



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обработка изменения количества
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.cart-item');
                const itemId = item.dataset.itemId;
                const input = item.querySelector('.quantity-input');
                const action = this.dataset.action;
                const currentValue = parseInt(input.value);

                let newValue = action === 'increase' ? currentValue + 1 : currentValue - 1;

                if (newValue < 1) return;

                fetch(`/cart/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: newValue,
                        _method: 'PUT'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            input.value = newValue;
                            // Обновляем общую стоимость товара
                            const itemTotal = item.querySelector('.item-total');
                            itemTotal.textContent = data.total + ' ₽';

                            // Обновляем общую стоимость корзины
                            document.querySelector('.total-price').textContent = data.cart_total + ' ₽';

                            // Обновляем счетчик корзины
                            updateCartCount();
                        } else {
                            alert('Ошибка при обновлении количества');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при обновлении количества');
                    });
            });
        });

        // Обработка удаления через AJAX
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!confirm('Удалить товар из корзины?')) return;

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.cart-item').remove();

                            // Обновляем общую стоимость
                            document.querySelector('.total-price').textContent = data.cart_total + ' ₽';

                            // Обновляем счетчик корзины
                            updateCartCount();

                            // Если корзина пуста, перезагружаем страницу
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при удалении товара');
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
