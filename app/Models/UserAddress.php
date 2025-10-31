<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'country',
        'postal_code',
        'is_primary',
        'phone',
        'recipient_name'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id', 'address_id');
    }

    // Scopes
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Аксессоры
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->country,
            $this->state,
            $this->city,
            $this->postal_code,
            $this->address_line
        ];

        return implode(', ', array_filter($parts));
    }

    public function getShortAddressAttribute()
    {
        return $this->city . ', ' . $this->address_line;
    }

    public function getRecipientInfoAttribute()
    {
        if ($this->recipient_name && $this->phone) {
            return $this->recipient_name . ' (' . $this->phone . ')';
        }
        return $this->recipient_name ?: $this->user->full_name;
    }

    // Методы
    public function setAsPrimary()
    {
        // Снимаем primary статус с других адресов пользователя
        UserAddress::where('user_id', $this->user_id)
            ->where('address_id', '!=', $this->address_id)
            ->update(['is_primary' => false]);

        $this->update(['is_primary' => true]);
    }

    public function isDeletable()
    {
        // Нельзя удалить адрес, если он используется в заказах
        return $this->orders()->count() === 0;
    }
}
