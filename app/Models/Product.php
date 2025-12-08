<?php

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
        'characteristics' => 'array' // Автоматическое преобразование JSON
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

    // Scope для поиска по категории
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope для поиска по названию
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    // Отношение к пользователям, которые добавили товар в избранное
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }

    // Проверка, добавлен ли товар в избранное текущим пользователем
    public function isInWishlist()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->wishlistedBy()->where('user_id', auth()->id())->exists();
    }
}
