<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'active',
        'featured',
        'stock_quantity',
        'category',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) $this->reviews()->avg('rating') ?? 0.0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}

