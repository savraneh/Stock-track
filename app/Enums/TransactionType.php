<?php

namespace App\Enums;

enum TransactionType: string
{
    case StockIn = 'stock_in';
    case StockOut = 'stock_out';
    case Adjustment = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::StockIn => 'Barang Masuk',
            self::StockOut => 'Barang Keluar',
            self::Adjustment => 'Penyesuaian Stok',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::StockIn => 'success',
            self::StockOut => 'warning',
            self::Adjustment => 'info',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
