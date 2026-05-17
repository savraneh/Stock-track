<?php

namespace App\Filament\Pages;

use App\Services\DemandAnalysisService;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class DemandAnalytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|UnitEnum|null $navigationGroup = 'Analytics & Reports';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Demand Analytics';

    protected static ?string $title = 'High Demand & Low Demand Analysis';

    protected string $view = 'filament.pages.demand-analytics';

    public static function canAccess(): bool
    {
        return auth()->user()?->canViewAnalytics() ?? false;
    }

    public function getHighDemandItems(): Collection
    {
        return app(DemandAnalysisService::class)->highDemand(10);
    }

    public function getLowDemandItems(): Collection
    {
        return app(DemandAnalysisService::class)->lowDemand(10);
    }
}
