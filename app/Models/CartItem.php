<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected $with = ['product'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }

    public function increaseQuantity(int $amount = 1): void
    {
        $this->increment('quantity', $amount);
    }

    public function decreaseQuantity(int $amount = 1): void
    {
        if ($this->quantity <= $amount) {
            $this->delete();
        } else {
            $this->decrement('quantity', $amount);
        }
    }
}
