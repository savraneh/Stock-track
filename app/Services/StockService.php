<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockService
{
    public function recordTransaction(
        Item $item,
        TransactionType|string $type,
        int $quantity,
        ?User $user = null,
        ?string $description = null,
    ): Transaction {
        $type = $type instanceof TransactionType ? $type : TransactionType::from($type);

        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Jumlah transaksi harus lebih dari 0.',
            ]);
        }

        return DB::transaction(function () use ($item, $type, $quantity, $user, $description): Transaction {
            /** @var Item $lockedItem */
            $lockedItem = Item::query()->lockForUpdate()->findOrFail($item->id);

            $stockBefore = $lockedItem->stock;
            $stockAfter = match ($type) {
                TransactionType::StockIn => $stockBefore + $quantity,
                TransactionType::StockOut => $stockBefore - $quantity,
                TransactionType::Adjustment => $quantity,
            };

            if ($stockAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok barang tidak mencukupi. Stok saat ini: '.$stockBefore.'.',
                ]);
            }

            $lockedItem->update([
                'stock' => $stockAfter,
            ]);

            return Transaction::query()->create([
                'item_id' => $lockedItem->id,
                'user_id' => $user?->id,
                'type' => $type,
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'description' => $description,
            ]);
        });
    }
}
