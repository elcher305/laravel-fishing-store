<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id'
        ]);

        try {
            $existingItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Товар уже в избранном'
                ]);
            }

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);

            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в избранное',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении в избранное'
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id'
        ]);

        try {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Товар удален из избранного',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении из избранного'
            ], 500);
        }
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id'
        ]);

        try {
            $existingItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->delete();
                $action = 'removed';
            } else {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id
                ]);
                $action = 'added';
            }

            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'action' => $action,
                'wishlist_count' => $wishlistCount,
                'message' => $action === 'added' ? 'Товар добавлен в избранное' : 'Товар удален из избранного'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении избранного'
            ], 500);
        }
    }
}
