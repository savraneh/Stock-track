<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Concerns\HasNavigationBreadcrumbs;
use App\Filament\Resources\Items\ItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    use HasNavigationBreadcrumbs;

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
