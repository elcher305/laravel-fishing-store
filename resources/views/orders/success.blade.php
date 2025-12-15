<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ успешно оформлен</title>
    <link rel="stylesheet" href="{{ asset('css/style-success.css') }}">

</head>
<body>
<div class="success-container">
    <div class="success-icon">
    </div>

    <h1 >Заказ успешно оформлен!</h1>
    <p >Спасибо за ваш заказ. Мы свяжемся с вами в ближайшее время.</p>

    <div class="order-number">
        № {{ $order->order_number }}
    </div>

    <div class="order-details">
        <div class="order-info-item">
            <span class="info-label">Дата и время:</span>
            <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
        </div>

        <div class="order-info-item">
            <span class="info-label">Сумма заказа:</span>
            <span class="info-value">{{ $order->total_amount }} руб.</span>
        </div>

        <div class="order-info-item">
            <span class="info-label">Способ доставки:</span>
            <span class="info-value">
                    @if($order->shipping_method == 'pickup')
                    Самовывоз
                @elseif($order->shipping_method == 'courier')
                    Курьерская доставка
                @elseif($order->shipping_method == 'post')
                    Почта России
                @else
                    {{ $order->shipping_method }}
                @endif
                </span>
        </div>

        <div class="order-info-item">
            <span class="info-label">Способ оплаты:</span>
            <span class="info-value">
                    @if($order->payment_method == 'cash')
                    Наличные при получении
                @elseif($order->payment_method == 'card')
                    Карта при получении
                @elseif($order->payment_method == 'online')
                    Онлайн оплата
                @else
                    {{ $order->payment_method }}
                @endif
                </span>
        </div>

        <div class="order-info-item">
            <span class="info-label">Статус:</span>
            <span class="info-value">
                    @if($order->status == 'pending')
                    Ожидает обработки
                @elseif($order->status == 'processing')
                    В обработке
                @elseif($order->status == 'completed')
                    Завершен
                @elseif($order->status == 'cancelled')
                    Отменен
                @else
                    {{ $order->status }}
                @endif
                </span>
        </div>

        @if($order->notes)
            <div class="order-info-item">
                <span class="info-label">Комментарий:</span>
                <span class="info-value">{{ $order->notes }}</span>
            </div>
        @endif
    </div>

    <div class="conditions" style="margin-top: 30px;">
        <strong>Что дальше?</strong><br>
        • В ближайшее время с вами свяжется наш менеджер для подтверждения заказа<br>
        • Вы можете отслеживать статус заказа в личном кабинете<br>
        • По всем вопросам обращайтесь по телефону: <strong>+7 (924) 613-43-45</strong>
    </div>

    <div class="action-buttons">
        <a href="{{ route('orders.show', $order) }}" class="primary-btn">
            Подробнее о заказе
        </a>
        <a href="{{ route('catalog.index') }}" class="secondary-btn">
            Вернуться в магазин
        </a>
        <a href="{{ route('orders.index') }}" class="secondary-btn">
            Мои заказы
        </a>
    </div>
</div>
</body>
</html>
