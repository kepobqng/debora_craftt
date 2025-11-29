<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'previous_stock',
        'current_stock',
        'reference',
        'notes',
        'movement_date'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'previous_stock' => 'integer',
        'current_stock' => 'integer',
        'movement_date' => 'date'
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
