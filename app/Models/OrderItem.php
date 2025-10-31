<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_item_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2'
    ];

    // Связи
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Аксессоры
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 0, '', ' ');
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 0, '', ' ');
    }

    // Методы
    public function updateStock()
    {
        if ($this->product) {
            $this->product->decrement('stock_quantity', $this->quantity);
        }
    }

    public function restoreStock()
    {
        if ($this->product) {
            $this->product->increment('stock_quantity', $this->quantity);
        }
    }
}
