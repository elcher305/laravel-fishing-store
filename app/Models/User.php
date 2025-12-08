<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'birth_date',
        'avatar',
        'gender',
        'fishing_experience',
        'about',
        'favorite_fishing_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d.m.Y') : 'Не указана';
    }

    public function getGenderLabelAttribute()
    {
        $genders = [
            'male' => 'Мужской',
            'female' => 'Женский',
            'other' => 'Другой'
        ];

        return $genders[$this->gender] ?? 'Не указан';
    }

    public function getExperienceLabelAttribute()
    {
        $experiences = [
            'beginner' => 'Начинающий',
            'amateur' => 'Любитель',
            'professional' => 'Профессионал'
        ];

        return $experiences[$this->fishing_experience] ?? 'Не указан';
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Генерация аватарки по умолчанию на основе имени
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

// Отношение к заказам

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

}
