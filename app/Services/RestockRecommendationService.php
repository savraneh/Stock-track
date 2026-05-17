<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Item;
use App\Models\RestockRecommendation;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class RestockRecommendationService
{
    public function generateForItem(Item $item, int $periodDays = 30): RestockRecommendation
    {
        $usage = Transaction::query()
            ->where('item_id', $item->id)
            ->where('type', TransactionType::StockOut->value)
            ->where('created_at', '>=', now()->subDays($periodDays))
            ->sum('quantity');

        $dailyAverage = round($usage / max($periodDays, 1), 2);
        $safetyGap = max($item->safe_stock - $item->stock, 0);
        $weeklyUsage = (int) ceil($dailyAverage * 7);
        $recommendedAmount = max($safetyGap, $weeklyUsage, $item->min_stock);

        return RestockRecommendation::query()->create([
            'item_id' => $item->id,
            'recommended_amount' => $recommendedAmount,
            'daily_usage_avg' => $dailyAverage,
            'status' => $item->stock <= $item->min_stock ? 'urgent' : 'planned',
            'generated_at' => now(),
        ]);
    }

    public function generateAllCritical(): Collection
    {
        return Item::query()
            ->critical()
            ->get()
            ->map(fn (Item $item): RestockRecommendation => $this->generateForItem($item));
    }
}
