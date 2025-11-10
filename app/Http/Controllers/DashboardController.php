<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->get();
        $addresses = UserAddress::where('user_id', $user->id)->get();

        return view('dashboard', compact('user', 'orders', 'addresses'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('dashboard')->with('success', 'Профиль обновлен успешно!');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        UserAddress::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Адрес добавлен успешно!');
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $request->total_amount,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Заказ оформлен успешно!');
    }

    public function createReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_name' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        // Проверяем, принадлежит ли заказ пользователю
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'product_name' => $request->product_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard')->with('success', 'Отзыв добавлен успешно!');
    }
}
