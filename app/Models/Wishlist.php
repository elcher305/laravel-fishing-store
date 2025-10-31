<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $primaryKey = 'wishlist_id';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    protected $casts = [
        'added_date' => 'datetime',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('added_date', '>=', now()->subDays($days));
    }

    public function scopeWithProductInfo($query)
    {
        return $query->with(['product.images', 'product.category', 'product.brand']);
    }

    // Аксессоры
    public function getIsProductAvailableAttribute()
    {
        return $this->product &&
            $this->product->status === 'in_stock' &&
            $this->product->stock_quantity > 0;
    }

    public function getProductPriceAttribute()
    {
        return $this->product ? $this->product->current_price : 0;
    }

    public function getFormattedProductPriceAttribute()
    {
        return $this->product ? number_format($this->product->current_price, 0, '', ' ') . ' ₽' : '0 ₽';
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->product_name : 'Товар не найден';
    }

    public function getProductSlugAttribute()
    {
        return $this->product ? $this->product->slug : '#';
    }

    public function getProductImageAttribute()
    {
        if ($this->product && $this->product->main_image) {
            return $this->product->main_image->image_url;
        }
        return asset('images/no-image.jpg');
    }

    // Методы
    public static function addToWishlist($userId, $productId)
    {
        // Проверяем, не добавлен ли уже товар в избранное
        $existing = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return $existing;
        }

        return self::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'added_date' => now()
        ]);
    }

    public static function removeFromWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public static function toggleWishlist($userId, $productId)
    {
        $existing = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return ['action' => 'removed', 'item' => null];
        } else {
            $item = self::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'added_date' => now()
            ]);
            return ['action' => 'added', 'item' => $item];
        }
    }

    public static function getUserWishlistCount($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    public static function getUserWishlist($userId, $paginate = false)
    {
        $query = self::with(['product.images', 'product.category', 'product.brand'])
            ->where('user_id', $userId)
            ->orderBy('added_date', 'desc');

        return $paginate ? $query->paginate(12) : $query->get();
    }

    public static function getWishlistProducts($userId)
    {
        return Product::whereHas('wishlistUsers', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['images', 'category', 'brand'])
            ->get();
    }

    public function moveToCart($quantity = 1)
    {
        if (!$this->product || !$this->is_product_available) {
            return false;
        }

        // Находим или создаем корзину пользователя
        $cart = Cart::firstOrCreate(
            ['user_id' => $this->user_id],
            ['session_id' => session()->getId()]
        );

        // Добавляем товар в корзину
        $cartItem = $cart->items()
            ->where('product_id', $this->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cartItem = $cart->items()->create([
                'product_id' => $this->product_id,
                'quantity' => $quantity
            ]);
        }

        // Удаляем из избранного
        $this->delete();

        return $cartItem;
    }

    public static function clearUserWishlist($userId)
    {
        return self::where('user_id', $userId)->delete();
    }

    // Проверяем, находится ли товар в избранном у пользователя
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    // Получаем рекомендованные товары на основе избранного
    public function getRecommendedProducts($limit = 4)
    {
        if (!$this->product) {
            return collect();
        }

        return Product::where('category_id', $this->product->category_id)
            ->where('product_id', '!=', $this->product_id)
            ->where('status', 'in_stock')
            ->where('stock_quantity', '>', 0)
            ->with(['images', 'brand'])
            ->limit($limit)
            ->get();
    }
}
