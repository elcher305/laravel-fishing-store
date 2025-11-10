<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'old_price',
        'category_id', 'brand_id', 'image', 'images', 'in_stock',
        'rating', 'review_count', 'features'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'in_stock' => 'boolean',
        'features' => 'array',
        'images' => 'array'
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

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Scopes для поиска
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

    // Атрибуты
    public function getMainFeaturesAttribute()
    {
        return $this->features ? array_slice($this->features, 0, 6) : [];
    }

    public function getHasDiscountAttribute()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->has_discount) return 0;

        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    public function getAllImagesAttribute()
    {
        $images = [];

        if ($this->image) {
            $images[] = $this->image;
        }

        if ($this->images && is_array($this->images)) {
            $images = array_merge($images, $this->images);
        }

        if (empty($images)) {
            $images[] = '/images/placeholder-product.jpg';
        }

        return $images;
    }
}
