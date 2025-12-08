{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.profile')

@section('title', 'Мой профиль')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="profile-sidebar text-center mb-4">
                <img src="{{ $user->avatar_url }}"
                     alt="{{ $user->name }}"
                     class="avatar-img rounded-circle mb-3">

                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>

                <div class="mb-3">
                    <span class="badge bg-primary">{{ $user->experience_label }}</span>
                    @if($user->favorite_fishing_type)
                        <span class="badge bg-info">{{ $user->favorite_fishing_type }}</span>
                    @endif
                </div>

                <div class="profile-nav">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profile.show') }}">
                                <i class="bi bi-person"></i> Профиль
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <i class="bi bi-pencil"></i> Редактировать профиль
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.password.edit') }}">
                                <i class="bi bi-key"></i> Изменить пароль
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-receipt"></i> Мои заказы
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Информация о профиле</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Редактировать
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%;">Имя:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Телефон:</th>
                                    <td>{{ $user->phone ?: 'Не указан' }}</td>
                                </tr>
                                <tr>
                                    <th>Пол:</th>
                                    <td>{{ $user->gender_label }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%;">Дата рождения:</th>
                                    <td>{{ $user->formatted_birth_date }}</td>
                                </tr>
                                <tr>
                                    <th>Опыт в рыбалке:</th>
                                    <td>{{ $user->experience_label }}</td>
                                </tr>
                                <tr>
                                    <th>Любимый вид ловли:</th>
                                    <td>{{ $user->favorite_fishing_type ?: 'Не указан' }}</td>
                                </tr>
                                <tr>
                                    <th>Адрес:</th>
                                    <td>{{ $user->address ?: 'Не указан' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($user->about)
                        <div class="mt-3">
                            <h6>Обо мне:</h6>
                            <p class="card-text">{{ $user->about }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> История заказов</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">
                        Все заказы
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
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
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
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $orders->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3">У вас еще нет заказов</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Перейти к покупкам
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
