<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'old_price',
        'category_id', 'brand_id', 'image', 'in_stock',
        'rating', 'review_count', 'features'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'in_stock' => 'boolean',
        'features' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Scopes для фильтрации
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeBrand($query, $brandIds)
    {
        if (is_array($brandIds)) {
            return $query->whereIn('brand_id', $brandIds);
        }
        return $query->where('brand_id', $brandIds);
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    public function scopeRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }
}
