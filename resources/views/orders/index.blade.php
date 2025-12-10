@extends('layouts.admin')

@section('title', 'Управление заказами')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управление заказами</h1>
        </div>

        <!-- Фильтры и поиск -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.index') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Статус заказа</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Все статусы</option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="search" class="form-label">Поиск</label>
                            <input type="text" name="search" id="search" class="form-control"
                                   placeholder="Номер заказа, имя, email..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Фильтровать</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Сбросить</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Статистика -->
        <div class="row mb-4">
            <div class="col-md-2 col-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ $orders->total() }}</h5>
                        <p class="card-text">Всего заказов</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">{{ App\Models\Order::status('pending')->count() }}</h5>
                        <p class="card-text">Ожидают</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ App\Models\Order::status('processing')->count() }}</h5>
                        <p class="card-text">В обработке</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ App\Models\Order::status('delivered')->count() }}</h5>
                        <p class="card-text">Доставлены</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Таблица заказов -->
        <div class="card">
            <div class="card-body">
                @if($orders->isEmpty())
                    <div class="text-center py-5">
                        <h4>Заказы не найдены</h4>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Номер заказа</th>
                                <th>Клиент</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Оплата</th>
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
                                    <td>
                                        {{ $order->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total, 2) }} ₽</strong>
                                    </td>
                                    <td>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                        {{ $statuses[$order->status] }}
                                    </span>
                                    </td>
                                    <td>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $order->payment_status == 'paid' ? 'Оплачен' : ($order->payment_status == 'pending' ? 'Ожидает' : 'Ошибка') }}
                                    </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="btn btn-info" title="Просмотр">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}"
                                               class="btn btn-primary" title="Редактировать">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.orders.destroy', $order) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Удалить заказ?')" title="Удалить">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
