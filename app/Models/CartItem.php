<?php
// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Отношение к пользователю
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Отношение к товару
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Аксессор для общей стоимости позиции
    public function getTotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    // Аксессор для форматированной суммы
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 0, ',', ' ') . ' ₽';
    }

    // Аксессор для форматированной цены
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }
}
