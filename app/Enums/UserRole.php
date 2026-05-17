<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Supervisor = 'supervisor';
    case Purchasing = 'purchasing';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Warehouse Admin',
            self::Supervisor => 'Supervisor',
            self::Purchasing => 'Purchasing',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role): array => [$role->value => $role->label()])
            ->all();
    }
}
