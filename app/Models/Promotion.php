<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $primaryKey = 'promotion_id';

    protected $fillable = [
        'promotion_name',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'code'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promotions', 'promotion_id', 'product_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeValidForAmount($query, $amount)
    {
        return $query->where(function($q) use ($amount) {
            $q->whereNull('min_order_amount')
                ->orWhere('min_order_amount', '<=', $amount);
        });
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Аксессоры
    public function getIsExpiredAttribute()
    {
        return $this->end_date < now();
    }

    public function getIsStartedAttribute()
    {
        return $this->start_date <= now();
    }

    public function getRemainingUsesAttribute()
    {
        if ($this->usage_limit === null) {
            return null;
        }
        return $this->usage_limit - $this->used_count;
    }

    public function getHasRemainingUsesAttribute()
    {
        return $this->remaining_uses === null || $this->remaining_uses > 0;
    }

    // Методы
    public function calculateDiscount($amount)
    {
        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = $amount * ($this->discount_value / 100);
        } else {
            $discount = $this->discount_value;
        }

        // Применяем максимальную скидку если указана
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return min($discount, $amount);
    }

    public function isValidForAmount($amount)
    {
        if (!$this->is_active || !$this->is_started || $this->is_expired) {
            return false;
        }

        if (!$this->has_remaining_uses) {
            return false;
        }

        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function incrementUsage()
    {
        $this->used_count++;
        return $this->save();
    }
}
