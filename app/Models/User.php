<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // Отношение к избранным товарам
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Товары в избранном через промежуточную таблицу
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
            ->withTimestamps();
    }

    // Проверка, есть ли товар в избранном
    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }
}
