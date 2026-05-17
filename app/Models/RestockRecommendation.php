<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestockRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'recommended_amount',
        'daily_usage_avg',
        'status',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'recommended_amount' => 'integer',
            'daily_usage_avg' => 'decimal:2',
            'generated_at' => 'datetime',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
