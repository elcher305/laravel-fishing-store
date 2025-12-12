<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/partials.styles.css') }}">
</head>
<body>


<div class="orders-container">
    <h1 class="page-title">Мои заказы</h1>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" style="margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-orders">
            <div class="empty-icon">📦</div>
            <h2>У вас еще нет заказов</h2>
            <p>Сделайте свой первый заказ в нашем каталоге товаров</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 20px;">
                Перейти в каталог
            </a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-number">Заказ №{{ $order->order_number }}</div>
                            <div class="order-date">Создан: {{ $order->created_at->format('d.m.Y H:i') }}</div>
                            @if($order->delivered_at)
                                <div class="order-date">Доставлен: {{ $order->delivered_at->format('d.m.Y') }}</div>
                            @endif
                        </div>
                        <div class="order-status status-{{ $order->status }}">
                            {{ $order->status_label }}
                        </div>
                    </div>

                    <div class="order-details">
                        <div class="detail-item">
                            <div class="detail-label">Способ доставки</div>
                            <div class="detail-value">{{ $order->delivery_method_label }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Способ оплаты</div>
                            <div class="detail-value">{{ $order->payment_method_label }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Адрес доставки</div>
                            <div class="detail-value">{{ $order->address->full_address ?? 'Не указан' }}</div>
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                <div class="item-name">{{ $item->product_name }}</div>
                                <div class="item-quantity">×{{ $item->quantity }}</div>
                                <div class="item-price">{{ number_format($item->total, 0, ',', ' ') }} ₽</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        <div>Итого:</div>
                        <div>{{ number_format($order->total, 0, ',', ' ') }} ₽</div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">
                            Подробнее
                        </a>

                        @if($order->canBeReviewed())
                            <a href="{{ route('reviews.create', $order->items->first()->product) }}" class="btn btn-primary">
                                Оставить отзыв
                            </a>
                        @endif

                        @if(in_array($order->status, ['pending', 'processing']))
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Вы уверены, что хотите отменить заказ?')">
                                    Отменить заказ
                                </button>
                            </form>
                        @endif

                        @if($order->status === 'delivered')
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                                Получено
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @endif
</div>

</body>
</html>
