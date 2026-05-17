<?php

namespace App\Models;

use App\Enums\StockStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'code',
        'name',
        'unit',
        'stock',
        'min_stock',
        'safe_stock',
        'unit_price',
        'image',
    ];

    protected $appends = [
        'stock_status_label',
    ];

    protected function casts(): array
    {
        return [
            'stock' => 'integer',
            'min_stock' => 'integer',
            'safe_stock' => 'integer',
            'unit_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function restockRecommendations(): HasMany
    {
        return $this->hasMany(RestockRecommendation::class);
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function (): StockStatus {
                if ($this->stock <= $this->min_stock) {
                    return StockStatus::Restock;
                }

                if ($this->stock <= $this->safe_stock) {
                    return StockStatus::Low;
                }

                return StockStatus::Safe;
            },
        );
    }

    protected function stockStatusLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->stock_status->label(),
        );
    }

    public function scopeNeedRestock(Builder $query): Builder
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('stock', '>', 'min_stock')
            ->whereColumn('stock', '<=', 'safe_stock');
    }

    public function scopeCritical(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->whereColumn('stock', '<=', 'safe_stock');
        });
    }
}
