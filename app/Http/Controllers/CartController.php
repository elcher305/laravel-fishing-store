<?php

namespace App\Http\Controllers;

use App\Providers\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartData = $this->cartService->getCartData();

        return view('cart.index', $cartData);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            $quantity = $request->quantity ?: 1;
            $cart = $this->cartService->addItem($request->product_id, $quantity);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Товар добавлен в корзину',
                    'cart' => [
                        'items_count' => $cart->items_count,
                        'total_amount' => $cart->total_amount,
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Товар добавлен в корзину');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = $this->cartService->updateQuantity($productId, $request->quantity);

            if ($request->ajax()) {
                $item = $cart->items()->where('product_id', $productId)->first();

                return response()->json([
                    'success' => true,
                    'item_total' => $item ? $item->total : 0,
                    'cart' => [
                        'items_count' => $cart->items_count,
                        'total_amount' => $cart->total_amount,
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Корзина обновлена');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove($productId)
    {
        try {
            $cart = $this->cartService->removeItem($productId);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Товар удален из корзины',
                    'cart' => [
                        'items_count' => $cart->items_count,
                        'total_amount' => $cart->total_amount,
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Товар удален из корзины');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function clear()
    {
        $this->cartService->clear();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Корзина очищена',
            ]);
        }

        return redirect()->back()->with('success', 'Корзина очищена');
    }

    public function getCartInfo()
    {
        $cartData = $this->cartService->getCartData();

        return response()->json([
            'items_count' => $cartData['items_count'],
            'total_amount' => $cartData['total_amount'],
        ]);
    }
}
