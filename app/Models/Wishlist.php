<?php
// app/Models/Wishlist.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];

    // Отношение к пользователю
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Отношение к товару
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
