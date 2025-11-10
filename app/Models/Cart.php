<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'total_amount',
        'items_count'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Обновить итоги корзины
    public function updateTotals()
    {
        $this->items_count = $this->items->sum('quantity');
        $this->total_amount = $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $this->save();
    }

    // Очистить корзину
    public function clear()
    {
        $this->items()->delete();
        $this->updateTotals();
    }

    // Получить корзину
    public static function getCart($user = null, $sessionId = null)
    {
        if ($user) {
            return static::firstOrCreate(['user_id' => $user->id]);
        } elseif ($sessionId) {
            return static::firstOrCreate(['session_id' => $sessionId]);
        }

        return null;
    }

    // Проверить пустая ли корзина
    public function getIsEmptyAttribute()
    {
        return $this->items_count === 0;
    }
}
