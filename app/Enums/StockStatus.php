<?php

namespace App\Enums;

enum StockStatus: string
{
    case Safe = 'safe';
    case Low = 'low';
    case Restock = 'restock';

    public function label(): string
    {
        return match ($this) {
            self::Safe => 'Safe',
            self::Low => 'Low',
            self::Restock => 'Needs Restock',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Safe => 'success',
            self::Low => 'warning',
            self::Restock => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status): array => [$status->value => $status->label()])
            ->all();
    }
}
