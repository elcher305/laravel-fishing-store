<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // Показать форму оформления заказа
    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        $total = $this->calculateTotal($cartItems);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    // Создать заказ
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_method' => 'required|in:pickup,delivery,courier',
            'payment_method' => 'required|in:cash,card,online',
            'notes' => 'nullable|string'
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        // Проверяем наличие товаров
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product->stock < $cartItem->quantity) {
                return back()->with('error',
                    'Товар "' . $cartItem->product->name . '" недоступен в нужном количестве');
            }
        }

        DB::beginTransaction();

        try {
            // Создаем заказ
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'total_amount' => $this->calculateTotal($cartItems)
            ]);

            // Добавляем товары в заказ и обновляем остатки
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->selected_size
                ]);

                // Уменьшаем количество на складе
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Очищаем корзину
            $this->clearCart();

            DB::commit();

            return redirect()->route('orders.success', $order)
                ->with('success', 'Заказ успешно оформлен! Номер заказа: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Произошла ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    // ========== Вспомогательные методы ==========

    private function getCartItems()
    {
        $sessionId = $this->getSessionId();

        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->orWhere('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        return CartItem::where('session_id', $sessionId)
            ->with('product')
            ->get();
    }

    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    private function clearCart()
    {
        $sessionId = $this->getSessionId();

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->orWhere('session_id', $sessionId)
                ->delete();
        } else {
            CartItem::where('session_id', $sessionId)->delete();
        }
    }

    private function getSessionId()
    {
        // Генерируем session_id, если его нет
        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', uniqid('cart_', true));
        }

        return Session::get('cart_session_id');
    }

    // ... остальные методы без изменений
}
