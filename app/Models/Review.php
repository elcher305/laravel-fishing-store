<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'pros',
        'cons',
        'is_approved',
        'is_verified_purchase'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_verified_purchase' => 'boolean',
        'pros' => 'array',
        'cons' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeHighRating($query)
    {
        return $query->where('rating', '>=', 4);
    }

    public function scopeLowRating($query)
    {
        return $query->where('rating', '<=', 2);
    }

    // Аксессоры
    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getShortCommentAttribute()
    {
        return \Str::limit($this->comment, 100);
    }

    // Методы
    public function approve()
    {
        $this->is_approved = true;
        return $this->save();
    }

    public function reject()
    {
        $this->is_approved = false;
        return $this->save();
    }
}
