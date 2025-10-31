<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'category_id',
        'brand_id',
        'weight',
        'dimensions',
        'features',
        'specifications',
        'is_active',
        'is_featured',
        'is_new',
        'slug',
        'meta_title',
        'meta_description',
        'warranty_months'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'features' => 'array',
        'specifications' => 'array',
        'weight' => 'decimal:2',
        'warranty_months' => 'integer'
    ];

    // Связи
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'product_promotions', 'product_id', 'promotion_id');
    }

    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlist', 'product_id', 'user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '<=', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('product_name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhere('short_description', 'like', "%{$searchTerm}%")
                ->orWhere('sku', 'like', "%{$searchTerm}%");
        });
    }

    // Аксессоры
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getMainImageAttribute()
    {
        return $this->images->where('is_primary', true)->first() ?? $this->images->first();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsInStockAttribute()
    {
        return $this->stock_quantity > 0;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->current_price, 0, '', ' ');
    }

    public function getFormattedDimensionsAttribute()
    {
        if ($this->dimensions) {
            return str_replace(['{', '}', '"'], '', $this->dimensions);
        }
        return null;
    }

    // Мутаторы
    public function setProductNameAttribute($value)
    {
        $this->attributes['product_name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    // Методы
    public function decreaseStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        return $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock_quantity += $quantity;
        return $this->save();
    }

    public function hasEnoughStock($quantity)
    {
        return $this->stock_quantity >= $quantity;
    }

    public function getRelatedProducts($limit = 4)
    {
        return self::where('category_id', $this->category_id)
            ->where('product_id', '!=', $this->product_id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }
}
