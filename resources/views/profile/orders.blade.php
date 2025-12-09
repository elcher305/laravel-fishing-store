@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
    <div class="profile-layout">
        <!-- Сайдбар -->
        <div class="sidebar">
            <h3>Меню</h3>
            <a href="{{ route('profile.show') }}">📋 Мой профиль</a>
            <a href="{{ route('profile.edit') }}">✏️ Редактировать профиль</a>
            <a href="{{ route('profile.orders') }}" class="active">📦 Мои заказы</a>
            <a href="{{ route('profile.change-password') }}">🔐 Изменить пароль</a>
        </div>

        <!-- Основной контент -->
        <div class="content">
            <div class="card">
                <h2>История заказов</h2>

                @if($orders->count() > 0)
                    <table class="table">
                        <thead>
                        <tr>
                            <th>№ Заказа</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} руб.</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'status-pending',
                                            'processing' => 'status-processing',
                                            'completed' => 'status-completed',
                                            'cancelled' => 'status-cancelled',
                                        ];
                                    @endphp
                                    <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                                    {{ $order->status }}
                                </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn" style="padding: 5px 10px; font-size: 14px;">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Пагинация -->
                    @if($orders->hasPages())
                        <div style="margin-top: 20px;">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div style="text-align: center; padding: 40px;">
                        <h3 style="color: #666; margin-bottom: 20px;">У вас пока нет заказов</h3>
                        <p style="color: #888;">Совершите свой первый заказ!</p>
                        <a href="/" class="btn" style="margin-top: 20px;">Перейти к покупкам</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
