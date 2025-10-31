<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_item_id';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'added_date' => 'datetime',
    ];

    // Связи
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Scopes
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    // Аксессоры
    public function getSubtotalAttribute()
    {
        if ($this->product) {
            return $this->quantity * $this->product->current_price;
        }
        return 0;
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 0, '', ' ');
    }

    public function getIsAvailableAttribute()
    {
        return $this->product && $this->product->stock_quantity >= $this->quantity;
    }

    public function getMaxAvailableQuantityAttribute()
    {
        return $this->product ? $this->product->stock_quantity : 0;
    }

    // Методы
    public function incrementQuantity($amount = 1)
    {
        $this->increment('quantity', $amount);
        $this->refresh();
    }

    public function decrementQuantity($amount = 1)
    {
        if ($this->quantity > $amount) {
            $this->decrement('quantity', $amount);
        } else {
            $this->delete();
            return null;
        }
        $this->refresh();
        return $this;
    }

    public function updateQuantity($newQuantity)
    {
        if ($newQuantity <= 0) {
            $this->delete();
            return null;
        }

        $this->update(['quantity' => $newQuantity]);
        return $this;
    }
}
