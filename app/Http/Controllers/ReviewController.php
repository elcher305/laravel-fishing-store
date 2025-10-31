<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
            'pros' => 'nullable|array',
            'cons' => 'nullable|array'
        ]);

        // Проверяем, покупал ли пользователь этот товар
        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereHas('items', function($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->where('status', 'delivered')
            ->exists();

        try {
            $review = Review::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'pros' => $request->pros,
                'cons' => $request->cons,
                'is_verified_purchase' => $hasPurchased,
                'is_approved' => false // Требует модерации
            ]);

            return redirect()->back()
                ->with('success', 'Отзыв отправлен на модерацию. Спасибо за ваш отзыв!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при отправке отзыва');
        }
    }

    public function update(Request $request, Review $review)
    {
        // Проверяем, что отзыв принадлежит пользователю
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
            'pros' => 'nullable|array',
            'cons' => 'nullable|array'
        ]);

        try {
            $review->update([
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'pros' => $request->pros,
                'cons' => $request->cons,
                'is_approved' => false // Снова отправляем на модерацию после изменения
            ]);

            return redirect()->back()
                ->with('success', 'Отзыв обновлен и отправлен на модерацию');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при обновлении отзыва');
        }
    }

    public function destroy(Review $review)
    {
        // Проверяем, что отзыв принадлежит пользователю
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $review->delete();

            return redirect()->back()
                ->with('success', 'Отзыв успешно удален');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении отзыва');
        }
    }

    public function userReviews()
    {
        $reviews = Review::with('product.images')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }
}
