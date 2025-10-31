<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'role_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Связи
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'user');
        });
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'admin');
        });
    }

    // Аксессоры
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->username;
    }

    public function getIsAdminAttribute()
    {
        return $this->role && $this->role->name === 'admin';
    }
}
