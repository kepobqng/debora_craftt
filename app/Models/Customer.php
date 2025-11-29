<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'birth_date',
        'gender',
        'total_orders',
        'total_spent'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'total_orders' => 'integer',
        'total_spent' => 'decimal:2'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
