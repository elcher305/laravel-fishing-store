{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            <i class="bi bi-cart"></i> Корзина покупок
        </h1>

        @if(isset($cartItems) && $cartItems->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Товары в корзине</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 50%">Товар</th>
                                        <th class="text-center">Цена</th>
                                        <th class="text-center">Количество</th>
                                        <th class="text-center">Сумма</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="product-img rounded me-3">
                                                    @else
                                                        <div class="product-img rounded bg-light d-flex align-items-center justify-content-center me-3">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name ?? 'Товар' }}</h6>
                                                        <small class="text-muted">
                                                            Категория: {{ $item->product->category ?? 'Не указана' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ number_format($item->price, 0, ',', ' ') }} ₽
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                        <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                                onclick="this.nextElementSibling.stepDown(); this.form.submit()">
                                                            -
                                                        </button>
                                                        <input type="number"
                                                               name="quantity"
                                                               value="{{ $item->quantity }}"
                                                               min="1"
                                                               max="10"
                                                               class="form-control text-center">
                                                        <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                                onclick="this.previousElementSibling.stepUp(); this.form.submit()">
                                                            +
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center align-middle fw-bold">
                                                {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Удалить товар из корзины?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left"></i> Продолжить покупки
                                </a>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Очистить всю корзину?')">
                                        <i class="bi bi-trash"></i> Очистить корзину
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Итого</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Товары:</th>
                                    <td class="text-end">{{ number_format($total, 0, ',', ' ') }} ₽</td>
                                </tr>
                                <tr>
                                    <th>Доставка:</th>
                                    <td class="text-end text-muted">Рассчитывается при оформлении</td>
                                </tr>
                                <tr>
                                    <th>Общая сумма:</th>
                                    <td class="text-end h5 text-primary">{{ number_format($total, 0, ',', ' ') }} ₽</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="d-grid gap-2 mt-4">
                                @auth
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg">
                                        <i class="bi bi-bag-check"></i> Оформить заказ
                                    </a>
                                @else
                                    <button class="btn btn-success btn-lg"
                                            onclick="if(confirm('Для оформления заказа требуется авторизация. Перейти на страницу входа?')) window.location.href='{{ route('login') }}'">
                                        <i class="bi bi-bag-check"></i> Оформить заказ
                                    </button>
                                    <p class="text-center small text-muted mt-2">
                                        Или <a href="{{ route('register') }}">зарегистрируйтесь</a>
                                    </p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    <h3 class="mt-3">Корзина пуста</h3>
                    <p class="text-muted">Добавьте товары в корзину для оформления заказа</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-arrow-left"></i> Перейти к товарам
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
