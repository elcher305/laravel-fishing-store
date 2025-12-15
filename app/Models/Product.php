<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image',
        'category', 'badge', 'sizes'
    ];

    protected $casts = [
        'sizes' => 'array',
        'price' => 'decimal:2'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);

    }
}
