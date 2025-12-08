<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'notes',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    // Статусы заказа
    public const STATUSES = [
        'pending' => 'Ожидает',
        'processing' => 'В обработке',
        'shipped' => 'Отправлен',
        'delivered' => 'Доставлен',
        'cancelled' => 'Отменен'
    ];

    // Отношение к пользователю
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Отношение к товарам в заказе
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Аксессор для форматированной суммы
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', ' ') . ' ₽';
    }

    // Аксессор для статуса на русском
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    // Аксессор для цвета статуса
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // Scope для фильтрации по статусу
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Генерация номера заказа
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $lastOrder = self::where('order_number', 'like', "ORD-{$date}-%")->latest()->first();

        if ($lastOrder) {
            $number = (int) substr($lastOrder->order_number, -4) + 1;
        } else {
            $number = 1;
        }

        return "ORD-{$date}-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
