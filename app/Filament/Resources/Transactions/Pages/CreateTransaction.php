<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Models\Item;
use App\Models\Transaction;
use App\Services\StockService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected ?bool $hasDatabaseTransactions = false;

    protected function handleRecordCreation(array $data): Model
    {
        $item = Item::query()->findOrFail($data['item_id']);

        return app(StockService::class)->recordTransaction(
            item: $item,
            type: $data['type'],
            quantity: (int) $data['quantity'],
            user: auth()->user(),
            description: $data['description'] ?? null,
        );
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Transaksi berhasil dicatat dan stok sudah diperbarui.';
    }
}
