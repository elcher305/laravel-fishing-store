@extends('layouts.orders')

@section('title', 'Заказ ' . $order->order_number)

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-receipt"></i> Заказ: {{ $order->order_number }}
            </h4>
            <div class="btn-group">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад
                </a>
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Информация о заказе</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%;">Номер заказа:</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th>Дата создания:</th>
                                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Статус:</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Ожидает',
                                                'processing' => 'В обработке',
                                                'shipped' => 'Отправлен',
                                                'delivered' => 'Доставлен',
                                                'cancelled' => 'Отменен'
                                            ];
                                            $color = $statusColors[$order->status] ?? 'secondary';
                                            $label = $statusLabels[$order->status] ?? $order->status;
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                        {{ $label }}
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Общая сумма:</th>
                                    <td class="fw-bold text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Информация о клиенте</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%;">ФИО:</th>
                                    <td>{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $order->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Телефон:</th>
                                    <td>{{ $order->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Адрес:</th>
                                    <td>{{ $order->customer_address ?: 'Не указан' }}</td>
                                </tr>
                                @if($order->notes)
                                    <tr>
                                        <th>Комментарий:</th>
                                        <td>{{ $order->notes }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Товары в заказе</h5>
                            <span class="badge bg-primary">{{ $order->items->count() }} позиций</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th class="text-center">Цена</th>
                                        <th class="text-center">Кол-во</th>
                                        <th class="text-end">Сумма</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div>{{ $item->product_name }}</div>
                                                @if($item->product)
                                                    <small class="text-muted">
                                                        ID: {{ $item->product_id }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end fw-bold">{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Итого:</th>
                                        <th class="text-end text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Изменение статуса</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <select name="status" class="form-select" required>
                                            @foreach($statuses as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ $order->status == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-check-circle"></i> Обновить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
