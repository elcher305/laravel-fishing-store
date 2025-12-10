@extends('layouts.admin')

@section('title', 'Редактирование заказа #' . $order->order_number)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Редактирование заказа #{{ $order->order_number }}</h1>
            <div>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Назад
                </a>
            </div>
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Левая колонка -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Информация о клиенте</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Имя клиента *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{ old('customer_name', $order->customer_name) }}" required>
                                @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                       id="customer_email" name="customer_email"
                                       value="{{ old('customer_email', $order->customer_email) }}" required>
                                @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Телефон *</label>
                                <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                       id="customer_phone" name="customer_phone"
                                       value="{{ old('customer_phone', $order->customer_phone) }}" required>
                                @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Адрес доставки *</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror"
                                          id="customer_address" name="customer_address" rows="3" required>{{ old('customer_address', $order->customer_address) }}</textarea>
                                @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Правая колонка -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Детали заказа</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Статус заказа *</label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('status', $order->status) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="payment_method" class="form-label">Способ оплаты *</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                            id="payment_method" name="payment_method" required>
                                        @foreach($paymentMethods as $value => $label)
                                            <option value="{{ $value }}" {{ old('payment_method', $order->payment_method) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="payment_status" class="form-label">Статус оплаты *</label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror"
                                            id="payment_status" name="payment_status" required>
                                        @foreach($paymentStatuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('payment_status', $order->payment_status) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="shipping" class="form-label">Стоимость доставки *</label>
                                    <input type="number" step="0.01" class="form-control @error('shipping') is-invalid @enderror"
                                           id="shipping" name="shipping"
                                           value="{{ old('shipping', $order->shipping) }}" required>
                                    @error('shipping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tax" class="form-label">Налог *</label>
                                <input type="number" step="0.01" class="form-control @error('tax') is-invalid @enderror"
                                       id="tax" name="tax" value="{{ old('tax', $order->tax) }}" required>
                                @error('tax')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Примечания</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes" name="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Суммы -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Сумма заказа</h5>
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
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">
                    Отмена
                </a>
                <button type="submit" class="btn btn-primary">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
@endsection
