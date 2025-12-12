<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Показать список заказов
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Показать форму оформления заказа
    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = 0;
        if ($subtotal < 5000) {
            $shippingCost = 300; // Пример стоимости доставки
        }

        $total = $subtotal + $shippingCost;

        return view('orders.checkout', compact('cartItems', 'addresses', 'subtotal', 'shippingCost', 'total'));
    }

    // Создать заказ
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:card,cash,online',
            'delivery_method' => 'required|in:pickup,courier,post',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $address = Address::findOrFail($request->address_id);

            // Рассчитываем суммы
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $shippingCost = $this->calculateShippingCost($subtotal, $request->delivery_method);
            $total = $subtotal + $shippingCost;

            // Создаем заказ
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'payment_method' => $request->payment_method,
                'delivery_method' => $request->delivery_method,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'notes' => $request->notes,
            ]);

            // Создаем элементы заказа
            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Уменьшаем количество на складе
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Очищаем корзину
            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ успешно оформлен! Номер заказа: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Произошла ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    // Показать детали заказа
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'address']);

        return view('orders.show', compact('order'));
    }

    // Отменить заказ
    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Нельзя отменить заказ в текущем статусе');
        }

        try {
            DB::beginTransaction();

            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            // Возвращаем товары на склад
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ успешно отменен');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Произошла ошибка при отмене заказа');
        }
    }

    // Рассчитать стоимость доставки
    private function calculateShippingCost($subtotal, $deliveryMethod)
    {
        if ($deliveryMethod === 'pickup') {
            return 0;
        }

        if ($subtotal >= 5000) {
            return 0; // Бесплатная доставка от 5000 руб
        }

        return match($deliveryMethod) {
            'courier' => 300,
            'post' => 200,
            default => 0,
        };
    }
}
