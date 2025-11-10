<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Общая стоимость позиции
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Увеличить количество
    public function incrementQuantity($amount = 1)
    {
        $this->quantity += $amount;
        $this->save();
        $this->cart->updateTotals();
    }

    // Уменьшить количество
    public function decrementQuantity($amount = 1)
    {
        $this->quantity = max(1, $this->quantity - $amount);
        $this->save();
        $this->cart->updateTotals();
    }

    // Обновить цену по текущей цене товара
    public function updatePrice()
    {
        $this->price = $this->product->price;
        $this->save();
        $this->cart->updateTotals();
    }
}
