<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product.images'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Проверяем, что заказ принадлежит текущему пользователю
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product.images', 'user']);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:user_addresses,address_id',
            'payment_method' => 'required|in:card,cash,online',
            'customer_notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $cart = Cart::with(['items.product'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Ваша корзина пуста');
            }

            // Проверяем наличие товаров
            foreach ($cart->items as $cartItem) {
                if (!$cartItem->product->hasEnoughStock($cartItem->quantity)) {
                    return redirect()->route('cart.index')
                        ->with('error', "Товар '{$cartItem->product->product_name}' недоступен в нужном количестве");
                }
            }

            // Получаем адрес доставки
            $shippingAddress = UserAddress::where('address_id', $request->shipping_address_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Рассчитываем общую сумму
            $totalAmount = $cart->items->sum(function ($item) {
                return $item->product->current_price * $item->quantity;
            });

            // Создаем заказ
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'new',
                'payment_method' => $request->payment_method,
                'shipping_address' => $shippingAddress->address_line,
                'customer_notes' => $request->customer_notes
            ]);

            // Создаем элементы заказа и обновляем остатки
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->current_price
                ]);

                // Уменьшаем количество на складе
                $cartItem->product->decreaseStock($cartItem->quantity);
            }

            // Очищаем корзину
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ успешно создан! Номер заказа: #' . $order->order_id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Произошла ошибка при создании заказа: ' . $e->getMessage());
        }
    }

    public function checkout()
    {
        $cart = Cart::with(['items.product.images'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Ваша корзина пуста');
        }

        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $subtotal = $cart->items->sum(function ($item) {
            return $item->product->current_price * $item->quantity;
        });

        return view('orders.checkout', compact('cart', 'addresses', 'subtotal'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['new', 'processing'])) {
            return redirect()->back()
                ->with('error', 'Невозможно отменить заказ в текущем статусе');
        }

        try {
            DB::beginTransaction();

            // Возвращаем товары на склад
            foreach ($order->items as $item) {
                $item->product->increaseStock($item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Заказ успешно отменен');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Ошибка при отмене заказа');
        }
    }
}
