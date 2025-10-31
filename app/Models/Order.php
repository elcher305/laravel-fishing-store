<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'customer_notes',
        'tracking_number',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('order_date', '>=', now()->subDays($days));
    }

    // Аксессоры
    public function getOrderNumberAttribute()
    {
        return 'ORD-' . str_pad($this->order_id, 6, '0', STR_PAD_LEFT);
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'new' => 'Новый',
            'processing' => 'В обработке',
            'paid' => 'Оплачен',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'card' => 'Карта',
            'cash' => 'Наличные',
            'online' => 'Онлайн'
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getItemsCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, ['new', 'processing']);
    }

    // Методы
    public function markAsPaid()
    {
        $this->update(['status' => 'paid']);
    }

    public function markAsShipped($trackingNumber = null)
    {
        $this->update([
            'status' => 'shipped',
            'tracking_number' => $trackingNumber,
            'shipped_at' => now()
        ]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);
    }

    public function cancel()
    {
        if ($this->can_be_cancelled) {
            // Возвращаем товары на склад
            foreach ($this->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }

            $this->update(['status' => 'cancelled']);
            return true;
        }

        return false;
    }
}
