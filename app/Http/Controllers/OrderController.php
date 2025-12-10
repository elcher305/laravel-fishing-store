<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1) Просмотр всех заказов
    public function index(Request $request)
    {
        $query = Order::with(['items', 'user'])
            ->latest();

        // Фильтрация по статусу
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Поиск
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);

        $statuses = [
            'pending' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен'
        ];

        return view('orders.index', compact('orders', 'statuses'));
    }

    // Просмотр деталей заказа
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        $statuses = [
            'pending' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен'
        ];

        $paymentStatuses = [
            'pending' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'failed' => 'Ошибка оплаты'
        ];

        return view('orders.show', compact('order', 'statuses', 'paymentStatuses'));
    }

    // Форма редактирования заказа
    public function edit(Order $order)
    {
        $order->load(['items.product']);

        $statuses = [
            'pending' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен'
        ];

        $paymentMethods = [
            'cash' => 'Наличные',
            'card' => 'Карта',
            'online' => 'Онлайн'
        ];

        $paymentStatuses = [
            'pending' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'failed' => 'Ошибка оплаты'
        ];

        return view('orders.edit', compact('order', 'statuses', 'paymentMethods', 'paymentStatuses'));
    }

    // Обновление заказа
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|in:cash,card,online',
            'payment_status' => 'required|in:pending,paid,failed',
            'shipping' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
        ]);

        // Пересчет общей суммы
        $validated['subtotal'] = $order->items->sum('total');
        $validated['total'] = $validated['subtotal'] + $validated['shipping'] + $validated['tax'];

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Заказ успешно обновлен.');
    }

    // Изменение статуса заказа (можно сделать через AJAX)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Здесь можно добавить логирование изменения статуса
        // или отправку уведомления клиенту

        return redirect()->back()
            ->with('success', "Статус заказа изменен с '{$oldStatus}' на '{$request->status}'");
    }

    // Удаление заказа
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Заказ успешно удален.');
    }

    // Экспорт заказов (опционально)
    public function export()
    {
        // Реализация экспорта в Excel или CSV
    }
}
