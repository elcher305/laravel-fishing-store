{{-- resources/views/cart/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            <i class="bi bi-bag-check"></i> Оформление заказа
        </h1>

        <form action="{{ route('cart.storeOrder') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Данные покупателя</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">ФИО *</label>
                                    <input type="text"
                                           class="form-control @error('customer_name') is-invalid @enderror"
                                           id="customer_name"
                                           name="customer_name"
                                           value="{{ old('customer_name', $user->name ?? '') }}"
                                           required>
                                    @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email *</label>
                                    <input type="email"
                                           class="form-control @error('customer_email') is-invalid @enderror"
                                           id="customer_email"
                                           name="customer_email"
                                           value="{{ old('customer_email', $user->email ?? '') }}"
                                           required>
                                    @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Телефон *</label>
                                <input type="tel"
                                       class="form-control @error('customer_phone') is-invalid @enderror"
                                       id="customer_phone"
                                       name="customer_phone"
                                       value="{{ old('customer_phone', $user->phone ?? '') }}"
                                       placeholder="+7 (999) 123-45-67"
                                       required>
                                @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Адрес доставки *</label>
                                <textarea class="form-control @error('delivery_address') is-invalid @enderror"
                                          id="delivery_address"
                                          name="delivery_address"
                                          rows="3"
                                          required>{{ old('delivery_address', $user->address ?? '') }}</textarea>
                                @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Комментарий к заказу</label>
                                <textarea class="form-control"
                                          id="notes"
                                          name="notes"
                                          rows="3"
                                          placeholder="Укажите дополнительные пожелания...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Ваш заказ</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th class="text-end">Сумма</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->name ?? 'Товар' }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $item->quantity }} × {{ number_format($item->price, 0, ',', ' ') }} ₽
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Товары:</th>
                                        <th class="text-end">{{ number_format($total, 0, ',', ' ') }} ₽</th>
                                    </tr>
                                    <tr>
                                        <th>Доставка:</th>
                                        <th class="text-end text-muted">Бесплатно</th>
                                    </tr>
                                    <tr>
                                        <th>Итого к оплате:</th>
                                        <th class="text-end h5 text-primary">{{ number_format($total, 0, ',', ' ') }} ₽</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input @error('agree_terms') is-invalid @enderror"
                                       type="checkbox"
                                       id="agree_terms"
                                       name="agree_terms"
                                       value="1"
                                       required>
                                <label class="form-check-label" for="agree_terms">
                                    Я согласен с <a href="#" target="_blank">условиями обработки персональных данных</a>
                                </label>
                                @error('agree_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle"></i> Подтвердить заказ
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Вернуться в корзину
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
