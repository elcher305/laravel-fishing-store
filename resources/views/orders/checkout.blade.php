<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/partials.styles.css') }}">
</head>
<body>
@include('partials.header')

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
                            <div class="method-icon">🚚</div>
                            <div class="method-name">Курьер</div>
                            <div class="method-desc">1-3 дня • 300 ₽</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="delivery_method" value="post"
                                   class="radio-input">
                            <div class="method-icon">📮</div>
                            <div class="method-name">Почта</div>
                            <div class="method-desc">3-7 дней • 200 ₽</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="delivery_method" value="pickup"
                                   class="radio-input">
                            <div class="method-icon">🏪</div>
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
                            <div class="method-icon">💳</div>
                            <div class="method-name">Карта онлайн</div>
                            <div class="method-desc">Безопасно</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="payment_method" value="cash"
                                   class="radio-input">
                            <div class="method-icon">💵</div>
                            <div class="method-name">Наличные</div>
                            <div class="method-desc">При получении</div>
                        </label>

                        <label class="method-option">
                            <input type="radio" name="payment_method" value="online"
                                   class="radio-input">
                            <div class="method-icon">🌐</div>
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
{{ $addresses->isEmpty() ? 'disabled' :
