<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Показать корзину
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
            'quantity' => 'sometimes|integer|min:1|max:' . $product->stock,
            'size' => 'sometimes|string'
        ]);

        // Получаем session_id
        $sessionId = $this->getSessionId();

        $cartItem = $this->findCartItem($product->id, $request->size, $sessionId);

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + ($request->quantity ?? 1);
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Недостаточно товара на складе');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $quantity = $request->quantity ?? 1;
            if ($quantity > $product->stock) {
                return back()->with('error', 'Недостаточно товара на складе');
            }

            CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : $sessionId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'selected_size' => $request->size
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }

    // Обновить количество
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Корзина обновлена');
    }

    // Удалить товар из корзины
    public function destroy(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Товар удален из корзины');
    }

    // Очистить корзину
    public function clear()
    {
        $sessionId = $this->getSessionId();

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', $sessionId)->delete();
        }

        return back()->with('success', 'Корзина очищена');
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

    private function findCartItem($productId, $size = null, $sessionId = null)
    {
        if (!$sessionId) {
            $sessionId = $this->getSessionId();
        }

        $query = CartItem::where('product_id', $productId);

        if (Auth::check()) {
            $query->where(function ($q) use ($sessionId) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', $sessionId);
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        if ($size) {
            $query->where('selected_size', $size);
        }

        return $query->first();
    }

    private function authorizeCartItem(CartItem $cartItem)
    {
        $sessionId = $this->getSessionId();

        if (Auth::check()) {
            if ($cartItem->user_id !== Auth::id() && $cartItem->session_id !== $sessionId) {
                abort(403, 'Этот элемент корзины вам не принадлежит');
            }
        } else {
            if ($cartItem->session_id !== $sessionId) {
                abort(403, 'Этот элемент корзины вам не принадлежит');
            }
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
}
