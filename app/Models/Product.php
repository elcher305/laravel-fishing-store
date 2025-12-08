<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'category',
        'characteristics',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'characteristics' => 'array'
    ];

    // Аксессор для полного URL изображения
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.jpg');
    }

    // Аксессор для форматированной цены
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }

    // Проверка наличия товара
    public function getInStockAttribute()
    {
        return $this->quantity > 0;
    }

    // Scope для активных товаров
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Добавляем отношения (из шага 7)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function isInWishlist()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->wishlists()->where('user_id', auth()->id())->exists();
    }
}
