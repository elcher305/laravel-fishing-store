<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'last_updated' => 'datetime',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeActive($query)
    {
        return $query->whereHas('items');
    }

    // Аксессоры
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->current_price;
        });
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount, 0, '', ' ');
    }

    public function getIsEmptyAttribute()
    {
        return $this->items->isEmpty();
    }

    // Методы
    public function addItem($productId, $quantity = 1)
    {
        $existingItem = $this->items()
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem;
        }

        return $this->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

    public function updateItemQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $item = $this->items()
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->update(['quantity' => $quantity]);
            return $item;
        }

        return null;
    }

    public function removeItem($productId)
    {
        return $this->items()
            ->where('product_id', $productId)
            ->delete();
    }

    public function clear()
    {
        return $this->items()->delete();
    }

    public function mergeWithSessionCart($sessionCart)
    {
        if ($sessionCart && $sessionCart->user_id === null) {
            foreach ($sessionCart->items as $sessionItem) {
                $this->addItem($sessionItem->product_id, $sessionItem->quantity);
            }
            $sessionCart->clear();
        }
    }

    public function checkout()
    {
        // Проверяем наличие всех товаров
        foreach ($this->items as $item) {
            if (!$item->product || $item->product->stock_quantity < $item->quantity) {
                throw new \Exception("Товар '{$item->product->product_name}' недоступен в нужном количестве");
            }
        }

        return $this;
    }
}
