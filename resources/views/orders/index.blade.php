@extends('layouts.orders')

@section('title', 'Управление заказами')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-cart-check"></i> Управление заказами</h1>
        <div>
            <a href="{{ route('orders.createDemo') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Создать тестовый заказ
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Всего заказов</h5>
                            <h2>{{ $totalOrders }}</h2>
                        </div>
                    </div>
                </div>

                @foreach($statuses as $key => $label)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">{{ $label }}</h6>
                                <h4>{{ $orders->where('status', $key)->count() }}</h4>
                                <a href="{{ route('orders.index', ['status' => $key]) }}" class="small">
                                    Показать
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Список заказов</h5>
                <div>
                    <form method="GET" class="d-flex">
                        <select name="status" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Все статусы</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>№ заказа</th>
                            <th>Клиент</th>
                            <th>Дата</th>
                            <th>Товары</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    <div>{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $order->items_count ?? 0 }} шт.</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                                </td>
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
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="btn btn-outline-info" title="Просмотр">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}"
                                           class="btn btn-outline-primary" title="Редактировать">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}"
                                              method="POST"
                                              onsubmit="return confirm('Удалить заказ?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $orders->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Заказов пока нет</h4>
                    <p class="text-muted">Создайте первый заказ для управления</p>
                    <a href="{{ route('orders.createDemo') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Создать тестовый заказ
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
