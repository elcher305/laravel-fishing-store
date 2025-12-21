<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image', 'characteristics',
        'category', 'badge', 'category_id'
    ];

    protected $casts = [
        'characteristics' => 'array',
        'price' => 'decimal:2'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default-product.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, ',', ' ') . ' ₽';
    }
}
