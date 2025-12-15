<!-- resources/views/orders/checkout.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="{{ asset('css/style-checkout.css') }}">
    <script src="../js/checkout.js"></script>
</head>
<body>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="checkout-container">
    <div class="checkout-column">
        <div class="container">
            <div class="header">
                Оформление заказа
            </div>

            <div >
                <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                    @csrf

                    <h3 class="section-title">Контактная информация</h3>

                    <div class="form-group">
                        <label for="customer_name" class="form-label">
                            ФИО <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="customer_name"
                               name="customer_name"
                               class="form-input"
                               value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                               required
                               placeholder="ФИО">
                    </div>

                    <div class="form-group">
                        <label for="customer_email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input type="email"
                               id="customer_email"
                               name="customer_email"
                               class="form-input"
                               value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                               required
                               placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="customer_phone" class="form-label">
                            Телефон <span class="required">*</span>
                        </label>
                        <input type="tel"
                               id="customer_phone"
                               name="customer_phone"
                               class="form-input"
                               value="{{ old('customer_phone') }}"
                               required
                               placeholder="+7 (999) 123-45-67">
                    </div>

                    <h3 class="section-title">Адрес доставки</h3>

                    <div class="form-group">
                        <label for="shipping_city" class="form-label">
                            Город <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="shipping_city"
                               name="shipping_city"
                               class="form-input"
                               value="{{ old('shipping_city') }}"
                               required
                               placeholder="Город">
                    </div>

                    <div class="form-group">
                        <label for="shipping_address" class="form-label">
                            Адрес <span class="required">*</span>
                        </label>
                        <textarea id="shipping_address"
                                  name="shipping_address"
                                  class="form-input"
                                  required
                                  placeholder="ул. Ленина, д. 10, кв. 5">{{ old('shipping_address') }}</textarea>
                    </div>

                    <h3 class="section-title">Способ доставки</h3>

                    <div class="radio-group shipping-methods">
                        <label class="radio-option">
                            <input type="radio"
                                   name="shipping_method"
                                   value="pickup"
                                   {{ old('shipping_method', 'pickup') == 'pickup' ? 'checked' : '' }}
                                   required>
                            <div class="option-label">Самовывоз</div>
                            <div class="option-price">Бесплатно</div>
                        </label>

                        <label class="radio-option">
                            <input type="radio"
                                   name="shipping_method"
                                   value="courier"
                                {{ old('shipping_method') == 'courier' ? 'checked' : '' }}>
                            <div class="option-label">Курьерская доставка</div>
                            <div class="option-price">300 руб.</div>
                        </label>

                        <label class="radio-option">
                            <input type="radio"
                                   name="shipping_method"
                                   value="post"
                                {{ old('shipping_method') == 'post' ? 'checked' : '' }}>
                            <div class="option-label">Почта России</div>
                            <div class="option-price">200 руб.</div>
                        </label>
                    </div>

                    <h3 class="section-title">Способ оплаты</h3>

                    <div class="radio-group payment-methods">
                        <label class="radio-option">
                            <input type="radio"
                                   name="payment_method"
                                   value="cash"
                                   {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}
                                   required>
                            <div class="option-label">Наличные при получении</div>
                        </label>

                        <label class="radio-option">
                            <input type="radio"
                                   name="payment_method"
                                   value="card"
                                {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                            <div class="option-label">Картой при получении</div>
                        </label>

                        <label class="radio-option">
                            <input type="radio"
                                   name="payment_method"
                                   value="online"
                                {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                            <div class="option-label">Онлайн оплата картой</div>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Комментарий к заказу</label>
                        <textarea id="notes"
                                  name="notes"
                                  class="form-input"
                                  placeholder="Дополнительные пожелания, время доставки и т.д.">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        Подтвердить заказ
                    </button>

                    <a href="{{ route('cart.index') }}" class="back-btn">
                        ← Вернуться в корзину
                    </a>
                </form>
            </div>
        </div>
    </div>

    <div class="checkout-column">
        <div class="container">
            <div class="header">
                Ваш заказ
            </div>

            <div style="padding: 25px;">
                <div class="order-summary">
                    @foreach($cartItems as $item)
                        <div class="order-item">
                            <div>
                                <div class="item-name">{{ $item->product->name }}</div>
                                @if($item->selected_size)
                                    <div class="item-details">Размер: {{ $item->selected_size }}</div>
                                @endif
                            </div>
                            <div class="item-total">
                                <div class="item-quantity">{{ $item->quantity }} шт. × {{ $item->product->price }} руб.</div>
                                <div class="item-price">{{ $item->product->price * $item->quantity }} руб.</div>
                            </div>
                        </div>
                    @endforeach

                    <div class="order-total">
                        <div class="total-label">Итого к оплате</div>
                        <div class="total-price">{{ $total }} руб.</div>
                    </div>
                </div>

                <div class="conditions">
                    <strong>Условия оформления заказа:</strong><br>
                    • Заказ будет обработан в течение 1 часа в рабочее время<br>
                    • С вами свяжется менеджер для подтверждения заказа<br>
                    • Отслеживание статуса заказа в личном кабинете<br>
                    • Возврат товара в течение 14 дней<br>
                    • Конфиденциальность данных гарантируется
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
