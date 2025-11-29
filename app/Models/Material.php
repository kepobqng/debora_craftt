<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'unit',
        'current_stock',
        'min_stock',
        'price',
        'type',
        'status',
        'supplier',
        'supplier_phone'
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'min_stock' => 'integer',
        'price' => 'decimal:2'
    ];

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
