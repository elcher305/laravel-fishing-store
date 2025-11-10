@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Левая колонка - Профиль и адреса -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Редактирование профиля -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Мой профиль</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Имя</label>
                            <input type="text" name="name" value="{{ $user->name }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Телефон</label>
                            <input type="text" name="phone" value="{{ $user->phone }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                            Обновить профиль
                        </button>
                    </div>
                </form>
            </div>

            <!-- Добавление адреса -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Добавить адрес</h3>
                <form method="POST" action="{{ route('address.add') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Адрес</label>
                            <input type="text" name="address"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Город</label>
                            <input type="text" name="city"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Почтовый индекс</label>
                            <input type="text" name="postal_code"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_default" id="is_default" class="mr-2">
                            <label for="is_default" class="text-gray-700">Сделать адресом по умолчанию</label>
                        </div>
                        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                            Добавить адрес
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Правая колонка - Заказы и отзывы -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Оформление заказа -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Оформление заказа</h3>
                <form method="POST" action="{{ route('order.create') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Адрес доставки</label>
                            <textarea name="shipping_address"
                                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                      rows="3" required></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Способ оплаты</label>
                            <select name="payment_method" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                                <option value="card">Банковская карта</option>
                                <option value="cash">Наличные</option>
                                <option value="online">Онлайн оплата</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Сумма заказа</label>
                            <input type="number" name="total_amount" step="0.01"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Примечания к заказу</label>
                            <textarea name="notes"
                                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                      rows="2"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600">
                            Оформить заказ
                        </button>
                    </div>
                </form>
            </div>

            <!-- История заказов -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">История заказов</h3>
                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold">Заказ #{{ $order->id }}</span>
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $order->status }}
                            </span>
                                </div>
                                <p class="text-gray-600">Сумма: {{ $order->total_amount }} руб.</p>
                                <p class="text-gray-600">Способ оплаты: {{ $order->payment_method }}</p>
                                <p class="text-gray-600">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</p>

                                <!-- Форма для отзыва -->
                                <div class="mt-3 border-t pt-3">
                                    <h4 class="font-semibold mb-2">Оставить отзыв</h4>
                                    <form method="POST" action="{{ route('review.create') }}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <input type="text" name="product_name" placeholder="Название товара"
                                                       class="w-full px-3 py-1 border rounded focus:outline-none focus:border-blue-500" required>
                                            </div>
                                            <div>
                                                <select name="rating" class="w-full px-3 py-1 border rounded focus:outline-none focus:border-blue-500" required>
                                                    <option value="">Оценка</option>
                                                    <option value="1">1 ★</option>
                                                    <option value="2">2 ★★</option>
                                                    <option value="3">3 ★★★</option>
                                                    <option value="4">4 ★★★★</option>
                                                    <option value="5">5 ★★★★★</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-2">
                                        <textarea name="comment" placeholder="Ваш отзыв"
                                                  class="w-full px-3 py-1 border rounded focus:outline-none focus:border-blue-500"
                                                  rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="mt-2 bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600 text-sm">
                                            Отправить отзыв
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">У вас пока нет заказов.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
