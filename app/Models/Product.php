<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'brand',
        'specifications',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'specifications' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('img/no-image.jpg');
    }

    /**
     * Получить характеристики в виде массива
     */
    public function getSpecsArrayAttribute()
    {
        if (!$this->specifications || !is_array($this->specifications)) {
            return [];
        }

        return $this->specifications;
    }

    /**
     * Проверить, есть ли товар в наличии
     */
    public function inStock()
    {
        return $this->stock > 0;
    }

    /**
     * Получить статус товара
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Неактивен';
        }

        return $this->inStock() ? 'В наличии' : 'Нет в наличии';
    }

    /**
     * Получить класс для статуса
     */
    public function getStatusClassAttribute()
    {
        if (!$this->is_active) {
            return 'secondary';
        }

        return $this->inStock() ? 'success' : 'danger';
    }
}
