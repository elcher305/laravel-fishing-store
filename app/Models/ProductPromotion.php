<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductPromotion extends Pivot
{
    protected $table = 'product_promotions';

    protected $primaryKey = 'product_promotion_id';

    public $incrementing = true;

    protected $fillable = [
        'product_id',
        'promotion_id',
        'discount_value_override'
    ];

    protected $casts = [
        'discount_value_override' => 'decimal:2'
    ];
}
