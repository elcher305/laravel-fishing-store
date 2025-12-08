<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Статусы заказов
    private $statuses = [
        'pending' => 'Ожидает',
        'processing' => 'В обработке',
        'shipped' => 'Отправлен',
        'delivered' => 'Доставлен',
        'cancelled' => 'Отменен'
    ];

    // 1) Просматривать все заказы
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Order::withCount('items');

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10);
        $totalOrders = Order::count();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => $this->statuses,
            'totalOrders' => $totalOrders
        ]);
    }

    // 2) Просматривать детали заказа
    public function show(Order $order)
    {
        $order->load('items');

        return view('orders.show', [
            'order' => $order,
            'statuses' => $this->statuses
        ]);
    }

    // 3) Форма редактирования заказа
    public function edit(Order $order)
    {
        $order->load('items');
        $products = Product::all();

        return view('orders.edit', [
            'order' => $order,
            'statuses' => $this->statuses,
            'products' => $products
        ]);
    }

    // 4) Обновление заказа
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $order->update($request->only([
            'status', 'customer_name', 'customer_email',
            'customer_phone', 'customer_address', 'notes'
        ]));

        return redirect()->route('orders.show', $order)
            ->with('success', 'Заказ успешно обновлен!');
    }

    // 5) Быстрое изменение статуса
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $this->statuses[$order->status] ?? $order->status;
        $order->update(['status' => $request->status]);
        $newStatus = $this->statuses[$request->status] ?? $request->status;

        return back()->with('success',
            "Статус изменен с \"{$oldStatus}\" на \"{$newStatus}\""
        );
    }

    // 6) Удаление заказа
    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Заказ успешно удален!');
    }

    // История заказов пользователя
    public function userOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);

        return view('orders.user-index', compact('orders'));
    }
    // 7) Создание тестового заказа
    public function createDemo()
    {
        DB::beginTransaction();

        try {
            $products = Product::all();

            if ($products->isEmpty()) {
                return back()->with('error', 'Нет товаров для создания заказа.');
            }

            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'customer_name' => 'Иван Иванов',
                'customer_email' => 'ivan@example.com',
                'customer_phone' => '+7 (999) 123-45-67',
                'customer_address' => 'ул. Примерная, д. 123, кв. 45',
                'status' => 'pending',
                'total_amount' => 0
            ]);

            $totalAmount = 0;
            $selectedProducts = $products->random(min(3, $products->count()));

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Тестовый заказ создан!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка создания заказа: ' . $e->getMessage());
        }
    }
}
