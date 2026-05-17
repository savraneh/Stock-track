<?php

namespace App\Filament\Resources\Suppliers\Pages;

use App\Filament\Concerns\HasNavigationBreadcrumbs;
use App\Filament\Resources\Suppliers\SupplierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuppliers extends ListRecords
{
    use HasNavigationBreadcrumbs;

    protected static string $resource = SupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
