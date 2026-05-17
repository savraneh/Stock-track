<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class Reports extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Analytics & Reports';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Reports';

    protected static ?string $title = 'Stock History Report';

    protected string $view = 'filament.pages.reports';

    public static function canAccess(): bool
    {
        return auth()->user()?->canViewAnalytics() ?? false;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getRecentTransactions(): Collection
    {
        return Transaction::query()
            ->with(['item.category', 'user'])
            ->latest()
            ->limit(15)
            ->get();
    }
}
