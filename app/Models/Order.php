<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'notes',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_phone',
        'order_date',
        'delivery_date'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'order_date' => 'date',
        'delivery_date' => 'date'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
