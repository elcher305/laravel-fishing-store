@extends('layouts.admin')

@section('title', 'Детали заказа #' . $order->order_number)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Заказ #{{ $order->order_number }}</h1>
            <div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Назад к списку
                </a>
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Основная информация -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Информация о заказе</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Информация о клиенте</h6>
                                <p><strong>Имя:</strong> {{ $order->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                                <p><strong>Адрес:</strong> {{ $order->customer_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Детали заказа</h6>
                                <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                                <p><strong>Статус:</strong>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                    {{ $statuses[$order->status] }}
                                </span>
                                </p>
                                <p><strong>Способ оплаты:</strong>
                                    {{ $order->payment_method == 'cash' ? 'Наличные' : ($order->payment_method == 'card' ? 'Карта' : 'Онлайн') }}
                                </p>
                                <p><strong>Статус оплаты:</strong>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $paymentStatuses[$order->payment_status] }}
                                </span>
                                </p>
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="mt-3">
                                <h6>Примечания:</h6>
                                <p>{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Товары в заказе -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Товары в заказе</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->product)
                                                <br>
                                                <small class="text-muted">Артикул: {{ $item->product->id }}</small>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->price, 2) }} ₽</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->total, 2) }} ₽</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Боковая панель с суммами и действиями -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Сумма заказа</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td>Стоимость товаров:</td>
                                <td class="text-end">{{ number_format($order->subtotal, 2) }} ₽</td>
                            </tr>
                            <tr>
                                <td>Доставка:</td>
                                <td class="text-end">{{ number_format($order->shipping, 2) }} ₽</td>
                            </tr>
                            <tr>
                                <td>Налог:</td>
                                <td class="text-end">{{ number_format($order->tax, 2) }} ₽</td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Итого:</strong></td>
                                <td class="text-end"><strong>{{ number_format($order->total, 2) }} ₽</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Быстрое изменение статуса -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Изменить статус</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.update-status', $order) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Обновить статус
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Действия -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Действия</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Редактировать заказ
                            </a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                        onclick="return confirm('Удалить этот заказ?')">
                                    <i class="fas fa-trash"></i> Удалить заказ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
