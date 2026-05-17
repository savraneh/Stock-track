<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CriticalStockAlerts;
use App\Filament\Widgets\RecentTransactionsWidget;
use App\Filament\Widgets\StockMovementChart;
use App\Filament\Widgets\StockStatsOverview;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            StockStatsOverview::class,
            StockMovementChart::class,
            CriticalStockAlerts::class,
            RecentTransactionsWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'lg' => 12,
        ];
    }
}
