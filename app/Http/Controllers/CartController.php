<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Главная страница корзины
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Добавить товар в корзину
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $quantity = $request->quantity;

        // Проверяем наличие товара
        if ($product->quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Недостаточно товара в наличии. Доступно: ' . $product->quantity
            ]);
        }

        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        // Ищем товар в корзине
        $cartItem = CartItem::where('product_id', $product->id)
            ->when($userId, function($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->first();

        if ($cartItem) {
            // Увеличиваем количество
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Добавляем новый товар
            CartItem::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        $cartCount = $this->getCartCount();

        return response()->json([
            'success' => true,
            'message' => 'Товар добавлен в корзину',
            'count' => $cartCount
        ]);
    }

    // Обновить количество
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')
            ->with('success', 'Количество обновлено');
    }

    // Удалить товар из корзины
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Товар удален из корзины');
    }

    // Очистить корзину
    public function clear()
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        CartItem::when($userId, function($query) use ($userId) {
            return $query->where('user_id', $userId);
        }, function($query) use ($sessionId) {
            return $query->where('session_id', $sessionId);
        })->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Корзина очищена');
    }

    // Оформление заказа (форма)
    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        $total = $this->calculateTotal($cartItems);
        $user = Auth::user();

        return view('cart.checkout', compact('cartItems', 'total', 'user'));
    }

    // Создание заказа
    public function storeOrder(Request $request)
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'status' => 'pending',
                'total_amount' => 0
            ]);

            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                // Создаем позицию заказа
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);

                $totalAmount += $cartItem->price * $cartItem->quantity;
            }

            $order->update(['total_amount' => $totalAmount]);

            // Очищаем корзину
            $this->clearCart();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ успешно оформлен! Номер заказа: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при оформлении заказа');
        }
    }

    // Количество товаров в корзине (API)
    public function count()
    {
        $count = $this->getCartCount();
        return response()->json(['count' => $count]);
    }

    // Содержимое корзины (API)
    public function content()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);

        return response()->json([
            'items' => $cartItems,
            'total' => $total
        ]);
    }

    // ========== ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ==========

    private function getSessionId()
    {
        $sessionId = session()->get('cart_session_id');

        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('cart_session_id', $sessionId);
        }

        return $sessionId;
    }

    private function getCartItems()
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        return CartItem::with('product')
            ->when($userId, function($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->get();
    }

    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    private function getCartCount()
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        return CartItem::when($userId, function($query) use ($userId) {
            return $query->where('user_id', $userId);
        }, function($query) use ($sessionId) {
            return $query->where('session_id', $sessionId);
        })->sum('quantity');
    }

    private function clearCart()
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        CartItem::when($userId, function($query) use ($userId) {
            return $query->where('user_id', $userId);
        }, function($query) use ($sessionId) {
            return $query->where('session_id', $sessionId);
        })->delete();
    }
}
