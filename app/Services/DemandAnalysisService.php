<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class DemandAnalysisService
{
    public function highDemand(int $limit = 10): Collection
    {
        return $this->baseDemandQuery()
            ->orderByDesc('total_out')
            ->limit($limit)
            ->get();
    }

    public function lowDemand(int $limit = 10): Collection
    {
        return $this->baseDemandQuery()
            ->orderBy('total_out')
            ->orderBy('items.name')
            ->limit($limit)
            ->get();
    }

    public function baseDemandQuery()
    {
        return Item::query()
            ->with(['category', 'supplier'])
            ->select('items.*')
            ->selectSub(
                Transaction::query()
                    ->selectRaw('COALESCE(SUM(quantity), 0)')
                    ->whereColumn('transactions.item_id', 'items.id')
                    ->where('type', TransactionType::StockOut->value),
                'total_out'
            );
    }
}
