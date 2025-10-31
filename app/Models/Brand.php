<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'brand_name',
        'description',
        'logo_url',
        'website',
        'slug',
        'is_active',
        'country'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Товары бренда
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit);
    }

    // Аксессоры
    public function getLogoAttribute()
    {
        if ($this->logo_url) {
            return asset('storage/' . $this->logo_url);
        }
        return asset('images/default-brand.png');
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}
