<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart()
    {
        $user = Auth::user();
        $sessionId = session()->getId();

        return Cart::getCart($user, $sessionId);
    }

    public function addItem($productId, $quantity = 1)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Проверяем наличие товара
        if (!$product->in_stock) {
            throw new \Exception('Товар отсутствует на складе');
        }

        // Ищем товар в корзине
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Увеличиваем количество существующего товара
            $cartItem->incrementQuantity($quantity);
        } else {
            // Добавляем новый товар
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        $cart->updateTotals();

        return $cart;
    }

    public function updateQuantity($productId, $quantity)
    {
        $cart = $this->getCart();

        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
            $cart->updateTotals();
        }

        return $cart;
    }

    public function removeItem($productId)
    {
        $cart = $this->getCart();
        $cart->items()->where('product_id', $productId)->delete();
        $cart->updateTotals();

        return $cart;
    }

    public function clear()
    {
        $cart = $this->getCart();
        $cart->clear();

        return $cart;
    }

    public function getCartData()
    {
        $cart = $this->getCart();

        return [
            'items' => $cart->items->load('product'),
            'total_amount' => $cart->total_amount,
            'items_count' => $cart->items_count,
        ];
    }

    // Объединение корзин при авторизации
    public function mergeCarts($user)
    {
        $sessionId = session()->getId();
        $sessionCart = Cart::where('session_id', $sessionId)->first();
        $userCart = Cart::where('user_id', $user->id)->first();

        if ($sessionCart && $userCart) {
            // Переносим товары из сессионной корзины в пользовательскую
            foreach ($sessionCart->items as $item) {
                $existingItem = $userCart->items()
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->incrementQuantity($item->quantity);
                } else {
                    CartItem::create([
                        'cart_id' => $userCart->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ]);
                }
            }

            $sessionCart->delete();
            $userCart->updateTotals();
        } elseif ($sessionCart) {
            // Привязываем сессионную корзину к пользователю
            $sessionCart->update(['user_id' => $user->id, 'session_id' => null]);
        }
    }
}
