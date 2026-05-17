<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class StockMovementChart extends ChartWidget
{
    protected ?string $heading = 'Transaction Trends';

    protected ?string $description = 'Stock movement activity based on transaction history.';

    protected string $color = 'primary';

    protected ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 6,
    ];

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '30s';

    public ?string $filter = '7';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Last 7 Days',
            '30' => 'Last 30 Days',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?? 7);
        $period = collect(CarbonPeriod::create(now()->subDays($days - 1)->startOfDay(), now()->startOfDay()));

        $labels = $period->map(fn ($date): string => $days > 7 ? $date->format('d M') : $date->format('D'))->all();

        $stockIn = $period->map(fn ($date): int => (int) Transaction::query()
            ->where('type', TransactionType::StockIn->value)
            ->whereDate('created_at', $date)
            ->sum('quantity'))->all();

        $stockOut = $period->map(fn ($date): int => (int) Transaction::query()
            ->where('type', TransactionType::StockOut->value)
            ->whereDate('created_at', $date)
            ->sum('quantity'))->all();

        return [
            'datasets' => [
                [
                    'label' => 'Stock In',
                    'data' => $stockIn,
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.12)',
                    'fill' => true,
                    'tension' => 0.42,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                ],
                [
                    'label' => 'Stock Out',
                    'data' => $stockOut,
                    'borderColor' => '#bc4800',
                    'backgroundColor' => 'rgba(188, 72, 0, 0.08)',
                    'fill' => true,
                    'tension' => 0.42,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 8,
                        'boxHeight' => 8,
                        'color' => '#434655',
                        'font' => [
                            'family' => 'Inter',
                            'size' => 12,
                            'weight' => 500,
                        ],
                    ],
                ],
                'tooltip' => [
                    'intersect' => false,
                    'mode' => 'index',
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => '#737686',
                        'font' => [
                            'family' => 'Inter',
                            'size' => 11,
                            'weight' => 500,
                        ],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(115, 118, 134, 0.16)',
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#737686',
                        'font' => [
                            'family' => 'Inter',
                            'size' => 11,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
