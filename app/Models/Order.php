<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_PREPARING = 'PREPARING';
    public const STATUS_READY = 'READY';
    public const STATUS_OUT_FOR_DELIVERY = 'OUT_FOR_DELIVERY';
    public const STATUS_DELIVERED = 'DELIVERED';
    public const STATUS_CANCELLED = 'CANCELLED';

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'delivery_address',
        'phone',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

