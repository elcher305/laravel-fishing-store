<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Показать форму создания отзыва
    public function create(Product $product)
    {
        // Проверяем, покупал ли пользователь этот товар
        $hasPurchased = Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Вы можете оставить отзыв только на купленные товары');
        }

        // Проверяем, не оставлял ли уже отзыв
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview);
        }

        return view('reviews.create', compact('product'));
    }

    // Сохранить отзыв
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Проверяем, покупал ли пользователь этот товар
        $hasPurchased = Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Вы можете оставить отзыв только на купленные товары');
        }

        // Проверяем, не оставлял ли уже отзыв
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview)
                ->with('error', 'Вы уже оставили отзыв на этот товар');
        }

        // Находим заказ, в котором был куплен товар
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->first();

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('products.show', $product)
            ->with('success', 'Отзыв успешно добавлен');
    }

    // Показать форму редактирования отзыва
    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    // Обновить отзыв
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('products.show', $review->product)
            ->with('success', 'Отзыв успешно обновлен');
    }

    // Удалить отзыв
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $product = $review->product;
        $review->delete();

        return redirect()->route('products.show', $product)
            ->with('success', 'Отзыв успешно удален');
    }

    // Показать все отзывы пользователя
    public function myReviews()
    {
        $reviews = Auth::user()->reviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.my', compact('reviews'));
    }
}
