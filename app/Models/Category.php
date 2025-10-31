<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'parent_category_id',
        'description',
        'image',
        'slug',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Родительская категория
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'category_id');
    }

    // Дочерние категории
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'category_id');
    }

    // Товары в категории
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_category_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('category_name');
    }

    // Аксессоры
    public function getFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->category_name . ' → ' . $this->category_name;
        }
        return $this->category_name;
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    // Метод для получения всех товаров категории (включая дочерние)
    public function getAllProducts()
    {
        $categoryIds = $this->getAllCategoryIds();
        return Product::whereIn('category_id', $categoryIds);
    }

    protected function getAllCategoryIds()
    {
        $categoryIds = [$this->category_id];

        foreach ($this->children as $child) {
            $categoryIds = array_merge($categoryIds, $child->getAllCategoryIds());
        }

        return $categoryIds;
    }
}
