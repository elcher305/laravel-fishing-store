<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product.images')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->current_price * $item->quantity;
        });

        $totalQuantity = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'subtotal', 'totalQuantity'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::active()->findOrFail($request->product_id);

            if (!$product->hasEnoughStock($request->quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно товара в наличии'
                ], 422);
            }

            $cart = $this->getOrCreateCart();

            // Проверяем, есть ли уже этот товар в корзине
            $existingItem = $cart->items()
                ->where('product_id', $product->product_id)
                ->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $request->quantity;

                if (!$product->hasEnoughStock($newQuantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Недостаточно товара в наличии'
                    ], 422);
                }

                $existingItem->update(['quantity' => $newQuantity]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->cart_id,
                    'product_id' => $product->product_id,
                    'quantity' => $request->quantity
                ]);
            }

            DB::commit();

            $cartCount = $cart->items()->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину',
                'cart_count' => $cartCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении товара в корзину'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,cart_item_id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $cartItem = CartItem::with('product')->findOrFail($request->item_id);

            // Проверяем, что корзина принадлежит текущему пользователю
            if ($cartItem->cart->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка доступа'
                ], 403);
            }

            if (!$cartItem->product->hasEnoughStock($request->quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно товара в наличии'
                ], 422);
            }

            $cartItem->update(['quantity' => $request->quantity]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Количество обновлено'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении количества'
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,cart_item_id'
        ]);

        try {
            $cartItem = CartItem::findOrFail($request->item_id);

            // Проверяем, что корзина принадлежит текущему пользователю
            if ($cartItem->cart->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка доступа'
                ], 403);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Товар удален из корзины'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении товара'
            ], 500);
        }
    }

    public function clear()
    {
        try {
            $cart = $this->getOrCreateCart();
            $cart->items()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Корзина очищена'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при очистке корзины'
            ], 500);
        }
    }

    public function getCartCount()
    {
        $cart = $this->getOrCreateCart();
        $count = $cart->items()->sum('quantity');

        return response()->json([
            'count' => $count
        ]);
    }

    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => session()->getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }
}
