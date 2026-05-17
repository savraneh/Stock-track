<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use Filament\Widgets\Widget;

class StockStatsOverview extends Widget
{
    protected string $view = 'filament.widgets.stock-stats-overview';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '30s';

    public function getStats(): array
    {
        return [
            [
                'label' => 'Total Items',
                'value' => number_format(Item::query()->count()),
                'icon' => 'heroicon-o-cube',
                'tone' => 'primary',
                'description' => 'All warehouse items',
            ],
            [
                'label' => 'Low Stock',
                'value' => number_format(Item::query()->critical()->count()),
                'icon' => 'heroicon-o-exclamation-triangle',
                'tone' => 'danger',
                'description' => 'Need attention',
            ],
            [
                'label' => "Today's Transactions",
                'value' => number_format(Transaction::query()->whereDate('created_at', today())->count()),
                'icon' => 'heroicon-o-receipt-percent',
                'tone' => 'tertiary',
                'description' => 'Stock activity today',
            ],
            [
                'label' => 'Total Categories',
                'value' => number_format(Category::query()->count()),
                'icon' => 'heroicon-o-tag',
                'tone' => 'secondary',
                'description' => 'Master category data',
            ],
        ];
    }
}
