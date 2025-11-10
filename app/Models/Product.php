<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'old_price', 'cost_price', 'category_id', 'brand_id',
        'image', 'images', 'in_stock', 'stock_quantity', 'is_featured',
        'is_active', 'weight', 'dimensions', 'features', 'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'images' => 'array',
        'features' => 'array',
        'weight' => 'decimal:2',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%");
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Attributes
    public function getHasDiscountAttribute()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->has_discount) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= 5) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function getStockStatusTextAttribute()
    {
        return [
            'out_of_stock' => 'Нет в наличии',
            'low_stock' => 'Мало на складе',
            'in_stock' => 'В наличии'
        ][$this->stock_status];
    }

    public function getMainImageAttribute()
    {
        return $this->image ?: '/images/placeholder-product.jpg';
    }

    // Methods
    public function updateStock($quantity)
    {
        $this->update([
            'stock_quantity' => $quantity,
            'in_stock' => $quantity > 0
        ]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (auth()->check()) {
                $product->created_by = auth()->id();
            }
        });
    }
}
