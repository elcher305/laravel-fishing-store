@extends('layouts.orders')

@section('title', 'Редактирование заказа ' . $order->order_number)

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i> Редактирование заказа: {{ $order->order_number }}
            </h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('orders.update', $order) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Основная информация</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Статус заказа *</label>
                                    <select name="status" id="status" class="form-select" required>
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('status', $order->status) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">ФИО клиента *</label>
                                    <input type="text"
                                           class="form-control"
                                           id="customer_name"
                                           name="customer_name"
                                           value="{{ old('customer_name', $order->customer_name) }}"
                                           required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_email" class="form-label">Email *</label>
                                        <input type="email"
                                               class="form-control"
                                               id="customer_email"
                                               name="customer_email"
                                               value="{{ old('customer_email', $order->customer_email) }}"
                                               required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="customer_phone" class="form-label">Телефон *</label>
                                        <input type="text"
                                               class="form-control"
                                               id="customer_phone"
                                               name="customer_phone"
                                               value="{{ old('customer_phone', $order->customer_phone) }}"
                                               required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Адрес доставки</label>
                                    <textarea class="form-control"
                                              id="customer_address"
                                              name="customer_address"
                                              rows="2">{{ old('customer_address', $order->customer_address) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Комментарий к заказу</label>
                                    <textarea class="form-control"
                                              id="notes"
                                              name="notes"
                                              rows="2">{{ old('notes', $order->notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Товары в заказе</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Цена</th>
                                            <th>Кол-во</th>
                                            <th>Сумма</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</td>
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

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Добавить товар</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="new_product_id" class="form-label">Выберите товар</label>
                                    <select id="new_product_id" class="form-select">
                                        <option value="">Выберите товар</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} ({{ number_format($product->price, 0, ',', ' ') }} ₽)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="new_quantity" class="form-label">Количество</label>
                                    <input type="number" id="new_quantity" class="form-control" min="1" value="1">
                                </div>
                                <button type="button" class="btn btn-outline-primary" onclick="addProduct()">
                                    <i class="bi bi-plus"></i> Добавить товар
                                </button>
                                <p class="text-muted mt-2 small">
                                    Для изменения состава заказа обратитесь к администратору
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function addProduct() {
                const select = document.getElementById('new_product_id');
                const quantity = document.getElementById('new_quantity').value;

                if (!select.value || quantity < 1) {
                    alert('Выберите товар и укажите количество');
                    return;
                }

                const productName = select.options[select.selectedIndex].text;
                const price = parseFloat(select.options[select.selectedIndex].dataset.price);
                const subtotal = price * quantity;

                alert('Товар "' + productName + '" добавлен.\nСумма: ' + subtotal.toFixed(0) + ' ₽\n\nДля полной интеграции требуется дополнительная разработка.');

                // Сброс формы
                select.value = '';
                document.getElementById('new_quantity').value = 1;
            }
        </script>
    @endpush
@endsection
