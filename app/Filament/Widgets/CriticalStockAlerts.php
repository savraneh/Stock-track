<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\StockMonitoring;
use App\Models\Item;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;

class CriticalStockAlerts extends Widget
{
    protected string $view = 'filament.widgets.critical-stock-alerts';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 4,
    ];

    protected static ?int $sort = 3;

    protected ?string $pollingInterval = '30s';

    public function getItems(): Collection
    {
        return Item::query()
            ->with(['category'])
            ->critical()
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(3)
            ->get();
    }

    public function getAllAlertsUrl(): string
    {
        return StockMonitoring::getUrl();
    }
}
