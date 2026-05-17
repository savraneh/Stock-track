<?php

namespace App\Filament\Pages;

use App\Models\Item;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class StockMonitoring extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-signal';

    protected static string|UnitEnum|null $navigationGroup = 'Stock Control';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Stock Monitoring';

    protected static ?string $title = 'Real-Time Stock Monitoring';

    protected string $view = 'filament.pages.stock-monitoring';

    public function getCriticalItems(): Collection
    {
        return Item::query()
            ->with(['category', 'supplier'])
            ->critical()
            ->orderBy('stock')
            ->limit(20)
            ->get();
    }

    public function getSafeCount(): int
    {
        return Item::query()
            ->whereColumn('stock', '>', 'safe_stock')
            ->count();
    }

    public function getLowCount(): int
    {
        return Item::query()->lowStock()->count();
    }

    public function getRestockCount(): int
    {
        return Item::query()->needRestock()->count();
    }
}
