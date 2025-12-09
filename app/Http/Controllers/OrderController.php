<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Показать все заказы пользователя
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }

    // Показать детали заказа
    public function show(Order $order)
    {
        // Проверяем, что заказ принадлежит текущему пользователю
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }

        return view('orders.show', compact('order'));
    }
}
