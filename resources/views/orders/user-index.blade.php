{{-- resources/views/orders/user-index.blade.php --}}
@extends('layouts.profile')

@section('title', 'Мои заказы')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-receipt"></i> Мои заказы</h5>
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Назад в профиль
            </a>
        </div>

        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>№ Заказа</th>
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
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $order->items->count() }} шт.</span>
                                </td>
                                <td>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</td>
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
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $orders->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Заказов пока нет</h4>
                    <p class="text-muted">Сделайте свой первый заказ в нашем магазине</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-bag"></i> Перейти к покупкам
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
