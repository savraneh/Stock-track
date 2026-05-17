<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Filament\Resources\Transactions\TransactionResource;
use App\Models\Transaction;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;

class RecentTransactionsWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-transactions-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    protected ?string $pollingInterval = '30s';

    public function getTransactions(): Collection
    {
        return Transaction::query()
            ->with(['item', 'user'])
            ->latest()
            ->limit(6)
            ->get();
    }

    public function getFullHistoryUrl(): string
    {
        return TransactionResource::getUrl('index');
    }

    public function getQuantityLabel(Transaction $transaction): string
    {
        $prefix = match ($transaction->type) {
            TransactionType::StockIn => '+',
            TransactionType::StockOut => '-',
            TransactionType::Adjustment => '',
        };

        return $prefix.number_format($transaction->quantity);
    }

    public function getTypeIcon(Transaction $transaction): string
    {
        return match ($transaction->type) {
            TransactionType::StockIn => 'heroicon-m-arrow-down-left',
            TransactionType::StockOut => 'heroicon-m-arrow-up-right',
            TransactionType::Adjustment => 'heroicon-m-arrows-right-left',
        };
    }

    public function getTypeTone(Transaction $transaction): string
    {
        return match ($transaction->type) {
            TransactionType::StockIn => 'primary',
            TransactionType::StockOut => 'tertiary',
            TransactionType::Adjustment => 'secondary',
        };
    }
}
