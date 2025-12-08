<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Отношение к заказу
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Отношение к товару
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Аксессор для форматированной цены
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }

    // Аксессор для форматированного субтотала
    public function getFormattedSubtotalAttribute(): string
    {
        return number_format($this->subtotal, 0, ',', ' ') . ' ₽';
    }
}
