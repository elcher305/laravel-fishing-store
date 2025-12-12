<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
</head>
<body>

<div class="checkout-container">
    <h1 style="margin-bottom: 30px;">Оформление заказа</h1>

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="checkout-grid">
            <div>
                <!-- Выбор адреса -->
                <div class="checkout-section">
                    <h2 class="section-title">Адрес доставки</h2>

                    @if($addresses->isEmpty())
                        <div class="alert alert-error">
                            У вас нет сохраненных адресов. <a href="{{ route('addresses.create') }}">Добавить адрес</a>
                        </div>
                    @else
                        <div class="address-list">
                            @foreach($addresses as $address)
                                <label class="address-item {{ $address->is_default ? 'selected' : '' }}">
                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                           class="radio-input"
                                           {{ $address->is_default ? 'checked' : '' }}
                                           required>
                                    <div class="address-title">{{ $address->title }}</div>
                                    <div class="address-details">{{ $address->full_address }}</div>
                                    <div class="address-details">Телефон: {{ $address->phone }}</div>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('addresses.create') }}" class="new-address-btn" style="margin-top: 15px;">
                        + Добавить новый адрес
                    </a>
                </div>

                <!-- Способ доставки -->
                <div class="checkout-section">
                    <h2 class="section-title">Способ доставки</h2>

                    <div class="method-options">
                        <label class="method-option selected">
                            <input type="radio" name="delivery_method" value="courier"
                                   class="radio-input" checked>
                            <div class="method-name">Курьер</div>
                            <div class="method-desc">1-3 дня • 300 ₽</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="delivery_method" value="post"
                                   class="radio-input">

                            <div class="method-name">Почта</div>
                            <div class="method-desc">3-7 дней • 200 ₽</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="delivery_method" value="pickup"
                                   class="radio-input">
                            <div class="method-name">Самовывоз</div>
                            <div class="method-desc">Бесплатно • Томск</div>
                        </label>
                    </div>
                </div>

                <!-- Способ оплаты -->
                <div class="checkout-section">
                    <h2 class="section-title">Способ оплаты</h2>

                    <div class="method-options">
                        <label class="method-option selected">
                            <input type="radio" name="payment_method" value="card"
                                   class="radio-input" checked>
                            <div class="method-icon"></div>
                            <div class="method-name">Карта онлайн</div>
                            <div class="method-desc">Безопасно</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="payment_method" value="cash"
                                   class="radio-input">
                            <div class="method-name">Наличные</div>
                            <div class="method-desc">При получении</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="payment_method" value="online"
                                   class="radio-input">
                            <div class="method-name">Электронные</div>
                            <div class="method-desc">Qiwi, YooMoney</div>
                        </label>
                    </div>
                </div>

                <!-- Комментарий к заказу -->
                <div class="checkout-section">
                    <h2 class="section-title">Комментарий к заказу</h2>
                    <textarea name="notes" class="notes-textarea"
                              placeholder="Дополнительные пожелания к заказу..."></textarea>
                </div>
            </div>

            <!-- Сводка заказа -->
            <div class="order-summary">
                <div class="checkout-section">
                    <h2 class="section-title">Ваш заказ</h2>

                    <div>
                        @foreach($cartItems as $item)
                            <div class="cart-item-checkout">
                                <div class="cart-item-name">{{ $item->product->name }}</div>
                                <div class="cart-item-quantity">×{{ $item->quantity }}</div>
                                <div class="cart-item-price">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} ₽</div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 20px;">
                        <div class="summary-item">
                            <span>Товары:</span>
                            <span>{{ number_format($subtotal, 0, ',', ' ') }} ₽</span>
                        </div>

                        <div class="summary-item">
                            <span>Доставка:</span>
                            <span id="shipping-cost">{{ number_format($shippingCost, 0, ',', ' ') }} ₽</span>
                        </div>

                        <div class="summary-total summary-item">
                            <span>Итого:</span>
                            <span id="total-price">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>

                    <button type="submit" class="checkout-btn"
                        {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                        Подтвердить заказ
                    </button>

                    <div class="conditions" style="margin-top: 20px; font-size: 12px; color: #666;">
                        Оформляя заказ, вы подтверждаете свое совершеннолетие и соглашаетесь с нашими условиями обработки персональных данных.
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include('partials.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обновление стоимости доставки при изменении способа
        const deliveryInputs = document.querySelectorAll('input[name="delivery_method"]');
        const shippingCostEl = document.getElementById('shipping-cost');
        const totalPriceEl = document.getElementById('total-price');
        const subtotal = {{ $subtotal }};

        deliveryInputs.forEach(input => {
            input.addEventListener('change', function() {
                const shippingCost = calculateShippingCost(this.value, subtotal);
                const total = subtotal + shippingCost;

                shippingCostEl.textContent = shippingCost.toLocaleString('ru-RU') + ' ₽';
                totalPriceEl.textContent = total.toLocaleString('ru-RU') + ' ₽';
            });
        });

        // Обновление кнопки при выборе адреса
        const addressInputs = document.querySelectorAll('input[name="address_id"]');
        const checkoutBtn = document.querySelector('.checkout-btn');

        addressInputs.forEach(input => {
            input.addEventListener('change', function() {
                checkoutBtn.disabled = false;
            });
        });

        // Выбор адреса/способа оплаты
        document.querySelectorAll('.address-item, .method-option').forEach(item => {
            item.addEventListener('click', function() {
                const radio = this.querySelector('.radio-input');
                if (radio) {
                    radio.checked = true;

                    // Обновляем стили выбранного элемента
                    if (this.classList.contains('address-item')) {
                        document.querySelectorAll('.address-item').forEach(addr => {
                            addr.classList.remove('selected');
                        });
                    } else if (this.classList.contains('method-option')) {
                        const name = radio.name;
                        document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                            inp.closest('.method-option').classList.remove('selected');
                        });
                    }

                    this.classList.add('selected');

                    // Если это способ доставки, пересчитываем стоимость
                    if (radio.name === 'delivery_method') {
                        const shippingCost = calculateShippingCost(radio.value, subtotal);
                        const total = subtotal + shippingCost;

                        shippingCostEl.textContent = shippingCost.toLocaleString('ru-RU') + ' ₽';
                        totalPriceEl.textContent = total.toLocaleString('ru-RU') + ' ₽';
                    }
                }
            });
        });

        function calculateShippingCost(method, subtotal) {
            if (method === 'pickup') return 0;
            if (subtotal >= 5000) return 0;

            return method === 'courier' ? 300 : 200;
        }
    });
</script>
</body>
</html>
